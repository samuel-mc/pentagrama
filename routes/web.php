<?php

use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\CourseByTeacherController;
use App\Http\Controllers\EstudentsByTeacherController;
use App\Http\Controllers\ReceptionistScheduleController;
use App\Http\Controllers\TimeSlotsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminDashboarController;
use App\Http\Controllers\AdminTeachersMagmentController;
use App\Http\Controllers\AdminAditionalInfoController;
use App\Http\Controllers\AdminStudentsController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AdminPersonalController;
use App\Http\Controllers\AdminGroupsController;
use App\Http\Controllers\AdminUsuariosController;
use App\Http\Controllers\ReceptionistAttendanceController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/faq', [HomeController::class, 'faq']);
Route::get('/about', [HomeController::class, 'about']);

// Section for add teachers, staff and students
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminDashboarController::class, 'index'])->middleware(['auth', 'user.role'])->name('admin.dashboard');
    Route::group(['prefix' => 'profesores'], function () {
        Route::get('/', [AdminTeachersMagmentController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::get('/agregar', [AdminTeachersMagmentController::class, 'addTeacher'])->middleware(['auth', 'user.role']);
        Route::post('/agregar', [AdminTeachersMagmentController::class, 'saveTeacher']);
        Route::get('/editar/{id}', [AdminTeachersMagmentController::class, 'editTeacher'])->middleware(['auth', 'user.role']);
        Route::post('/editar/{id}', [AdminTeachersMagmentController::class, 'updateTeacher']);
        Route::get('/dashboard', [DashboardController::class, 'displayTeacherDashboard'])->middleware(['auth', 'user.role']);

        Route::get('/horarios-disponibles', [AdminTeachersMagmentController::class, 'teacherSchedule'])->middleware(['auth', 'user.role'])->name('admin.profesores.horarios-disponibles');
        Route::get('/horarios-disponibles/agregar', [AdminTeachersMagmentController::class, 'setTeacherTimeSlot'])->name('admin.profesores.horarios-disponibles.agregar');

        Route::get('/mis-estudiantes', [EstudentsByTeacherController::class, 'index'])->middleware(['auth', 'user.role']);
    });
    Route::group(['prefix' => 'info-adicional'], function () {
        Route::get('/', [AdminAditionalInfoController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::group(['prefix' => 'como-nos-encontraste'], function () {
            Route::get('/', [AdminAditionalInfoController::class, 'comoNosEncontraste'])->middleware(['auth', 'user.role']);
            Route::get('/agregar', [AdminAditionalInfoController::class, 'addComoNosEncontraste'])->middleware(['auth', 'user.role']);
            Route::post('/agregar', [AdminAditionalInfoController::class, 'saveComoNosEncontraste']);
            Route::get('/editar/{id}', [AdminAditionalInfoController::class, 'editComoNosEncontraste'])->middleware(['auth', 'user.role']);
            Route::post('/editar/{id}', [AdminAditionalInfoController::class, 'updateComoNosEncontraste']);
        });
        Route::group(['prefix' => 'catedras'], function () {
            Route::get('/', [AdminAditionalInfoController::class, 'catedras'])->middleware(['auth', 'user.role']);
            Route::get('/agregar', [AdminAditionalInfoController::class, 'addCatedra'])->middleware(['auth', 'user.role']);
            Route::post('/agregar', [AdminAditionalInfoController::class, 'saveCatedra']);
            Route::get('/editar/{id}', [AdminAditionalInfoController::class, 'editCatedra'])->middleware(['auth', 'user.role']);
            Route::post('/editar/{id}', [AdminAditionalInfoController::class, 'updateCatedra']);
        });
        Route::group(['prefix' => 'edades'], function () {
            Route::get('/', [AdminAditionalInfoController::class, 'edades'])->middleware(['auth', 'user.role']);
            Route::get('/agregar', [AdminAditionalInfoController::class, 'addEdad'])->middleware(['auth', 'user.role']);
            Route::post('/agregar', [AdminAditionalInfoController::class, 'saveEdad']);
            Route::get('/editar/{id}', [AdminAditionalInfoController::class, 'editEdad'])->middleware(['auth', 'user.role']);
            Route::post('/editar/{id}', [AdminAditionalInfoController::class, 'updateEdad']);
        });
        Route::group(['prefix' => 'horarios-disponibles'], function () {
            Route::get('/', [TimeSlotsController::class, 'index'])->middleware(['auth', 'user.role'])->name('admin.horarios-disponibles');
            Route::get('/agregar', [TimeSlotsController::class, 'addCatalogoHorario'])->middleware(['auth', 'user.role']);
            Route::post('/agregar', [TimeSlotsController::class, 'saveCatalogoHorario']);
            Route::get('/eliminar/{id}', [TimeSlotsController::class, 'deleteTimeSlot']);
        });
    });
    Route::group(['prefix' => 'inscripcion'], function () {
        Route::get('/', [InscriptionController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::post('/', [InscriptionController::class, 'save']);
    });
    Route::group(['prefix' => 'estudiantes'], function () {
        Route::get('/', [AdminStudentsController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::get('/{id}', [AdminStudentsController::class, 'studentDetail'])->middleware(['auth', 'user.role']);
        Route::post('/{id}/password', [AdminStudentsController::class, 'updatePassword'])->name('admin.estudiantes.password');
        Route::get('{id}/pagos', [AdminStudentsController::class, 'studentPayments'])->middleware(['auth', 'user.role']);
        Route::get('{id}/pagos/agregar', [AdminStudentsController::class, 'addPayment'])->middleware(['auth', 'user.role']);
        Route::post('{id}/pagos/agregar', [AdminStudentsController::class, 'savePayment']);
        Route::get('/pagos/detalle/{paymentId}', [AdminStudentsController::class, 'detailPayment'])->middleware(['auth', 'user.role']);
        Route::get('/{id}/grupos', [AdminStudentsController::class, 'studentGroups']);
        Route::get('/{id}/grupos/agregar', [AdminStudentsController::class, 'addGroup']);
        Route::post('/{id}/grupos/agregar', [AdminStudentsController::class, 'saveGroup']);
    });
    Route::group(['prefix' => 'personal'], function () {
        Route::get('/', [AdminPersonalController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::get('/agregar', [AdminPersonalController::class, 'create'])->middleware(['auth', 'user.role']);
        Route::post('/agregar', [AdminPersonalController::class, 'store']);
    });
    Route::group(['prefix' => 'grupos'], function () {
        Route::get('/', [AdminGroupsController::class, 'index']);
        Route::get('/agregar', [AdminGroupsController::class, 'addGroup'])->name('admin.grupos.agregar');
        Route::post('/agregar', [AdminGroupsController::class, 'saveGroup']);
        Route::get('/{studentId}/{teacherId}/{courseId}', [AdminGroupsController::class, 'getGroupByStudentTeacherCourse']);
    });
    // users
    Route::get('/usuarios', [AdminUsuariosController::class, 'index'])->middleware(['auth', 'user.role']);
    Route::get('/cuentas', [AdminStudentsController::class, 'accounts'])->name('admin.cuentas')->middleware(['auth', 'user.role']);
    Route::get('/cuentas/{id}', [AdminStudentsController::class, 'accountDetail'])->name('admin.cuentas.detalle');
    Route::group(['prefix' => 'asistencia'], function () {
        Route::get('/', [ReceptionistAttendanceController::class, 'index'])->middleware(['auth', 'user.role']);
        Route::post('/', [ReceptionistAttendanceController::class, 'registerAttendance'])->name('admin.asistencia.registrar');
        Route::post('/profesor', [ReceptionistAttendanceController::class, 'registerTeacherAttendance'])->name('admin.asistencia.profesor');
        Route::post('/suplente', [ReceptionistAttendanceController::class, 'addSubstituteTeacher'])->name('admin.asistencia.suplente');
    });
    Route::get('/recepcionista/horarios', [ReceptionistScheduleController::class, 'index']);
    Route::group(['prefix' => '/horarios'], function () {
        Route::get('/', [AdminScheduleController::class, 'index'])->middleware(['auth', 'user.role'])->name('admin.horarios');
        Route::get('/agregar', [AdminScheduleController::class, 'addSchedule'])->middleware(['auth', 'user.role'])->name('admin.horarios.agregar');
        Route::post('/agregar', [AdminScheduleController::class, 'saveSchedule'])->name('admin.horarios.agregar');
        Route::get('/editar/{id}', [AdminScheduleController::class, 'editSchedule']);
        Route::post('/editar/{id}', [AdminScheduleController::class, 'updateSchedule']);
        Route::get('goto', [AdminScheduleController::class, 'goTo']);
    });
    //course by teacher
    Route::group(['prefix' => 'cursos-por-profesor'], function () {
        Route::get('/{id}', [CourseByTeacherController::class, 'getCoursesByTeacher']);
        Route::get('/profesores/agregar', [CourseByTeacherController::class, 'setCourseByTeacher'])->name('admin.cursos-por-profesor.agregar');
    });
});

Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
