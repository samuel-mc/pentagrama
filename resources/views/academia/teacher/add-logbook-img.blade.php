@extends('academia.layout.app')

@section('content')
    <div id="errors"></div>
    <form action="{{route('admin.profesores.bitacora.save-imagen')}}" method="post" id="addLogbookForm" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 my-4">
            <input type="hidden" name="logbook_id" value="{{$logbook->id}}">
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Cátedra - estudiante</h3>
                <input type="text" class="input w-full" value="{{$logbook->group->course->name}} - {{$logbook->group->student->name}} {{$logbook->group->student->last_name}}" disabled>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Fecha</h3>
                <input type="text" class="input w-full" value="{{$logbook->date}}" disabled>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Tema</h3>
                <input type="text" class="input w-full" value="{{$logbook->title}}" disabled>
            </div>
            <div>
                <h3 class="text-sm mb-1 text-light_pink">Canciones</h3>
                <input type="text" class="input w-full" placeholder="Canciones" value="{{$logbook->song}}">
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


            const errors = [];

            const image = document.getElementById('image').files[0];

            if (!image) {
                errors.push('Debe seleccionar una imagen');
            }

            //validar que sea menor a 2048 KiB
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
