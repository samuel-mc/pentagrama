@extends('academia.layout.app')

@section('content')
    <div id="errors"></div>
    <form action="{{route('admin.bitacora.save')}}" method="post" id="addLogbookForm" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-4">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Cátedra - estudiante</h3>
                <select name="course" id="course" class="input w-full">
                    <option value="">Seleccione una cátedra - estudante</option>
                    @foreach($groupsByTeacher as $course)
                        <option value="{{$course->id}}"> {{$course->course->name}} - {{$course->student->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Fecha</h3>
                <input type="date" name="date" class="input w-full">
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Tema</h3>
                <input type="text" name="topic" class="input w-full" placeholder="Tema">
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Canciones</h3>
                <input type="text" name="songs" class="input w-full" placeholder="Canciones">
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Imagen</h3>
                <input type="file" name="image" class="input w-full" accept="image/*" id="image">
            </div>
        </div>
        <div class="text-end">
            <button type="button" class="btn btn--secondary" onclick="handleGoBack()">Cancelar</button>
            <button type="submit" class="btn btn--primary">Guardar</button>
        </div>
    </form>
    <script>
        const logbookForm = document.getElementById('addLogbookForm');
        logbookForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const data = new FormData(logbookForm);
            console.log(data);

            const errors = [];
            if (!data.get('course')) {
                errors.push('Debe seleccionar una cátedra');
            }
            if (!data.get('date')) {
                errors.push('Debe seleccionar una fecha');
            }
            if (!data.get('topic')) {
                errors.push('Debe ingresar un tema');
            }
            if (!data.get('songs')) {
                errors.push('Debe ingresar canciones');
            }

            const image = document.getElementById('image').files[0];

            if (image.size > 2097152) {
                errors.push('La imagen debe ser menor a 2MB');
            }

            console.log(errors);

            if(errors.length > 0) {
                const errorDiv = document.getElementById('errors');
                const errorList = document.createElement('ul');
                errorList.setAttribute('class', 'list-disc list-inside w-full bg-red-100 border-2 border-red-500 rounded p-2 my-5');
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.setAttribute('class', 'text-red-500');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                errorDiv.innerHTML = '';
                errorDiv.appendChild(errorList);
                return;
            }

            this.submit();


        });

        const handleGoBack = () => {
            window.history.back();
        }

    </script>
@endsection

