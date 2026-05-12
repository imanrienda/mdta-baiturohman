<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES - Tanpa Login (untuk calon siswa daftar)
|--------------------------------------------------------------------------
*/
Route::get('/daftar', 'PendaftaranController@create')->name('pendaftaran.create');
Route::post('/daftar', 'PendaftaranController@store')->name('pendaftaran.store');
Route::get('/daftar/bukti/{id}', 'PendaftaranController@show')->name('pendaftaran.show');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - Hanya untuk guest (belum login)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@proses');
});

Route::get('/logout', 'AuthController@logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
    Route::get('/dashboard', 'DashboardController@index');

    Route::get('/students', 'StudentsController@index');
    Route::get('students/create', 'StudentsController@create');
    Route::post('students', 'StudentsController@store');
    Route::get('students/{student}/edit', 'StudentsController@edit');
    Route::put('students/{student}', 'StudentsController@update');
    Route::delete('students/{student}', 'StudentsController@destroy');
    Route::get('students/{student}', 'StudentsController@show');

    Route::get('/class-students', 'StudentsController@classStudent');
    Route::post('/class-student-by-student', 'StudentsController@storeClassStudentByStudent');
    Route::delete('/class-students/{classStudent}', 'StudentsController@destroyClassStudent');

    Route::get('/teachers', 'TeachersController@index');
    Route::get('teachers/create', 'TeachersController@create');
    Route::post('teachers', 'TeachersController@store');
    Route::get('teachers/{teacher}/edit', 'TeachersController@edit');
    Route::put('teachers/{teacher}', 'TeachersController@update');
    Route::delete('teachers/{teacher}', 'TeachersController@destroy');
    Route::get('teachers/{teacher}', 'TeachersController@show');

    Route::get('/wali-kelas', 'HomeroomTeachersController@index');
    Route::get('/wali-kelas/{semester_id}/create', 'HomeroomTeachersController@create');
    Route::post('/wali-kelas', 'HomeroomTeachersController@store');
    Route::delete('/wali-kelas/{homeroomTeacher}', 'HomeroomTeachersController@destroy');

    Route::get('/class-rooms', 'ClassRoomsController@index');
    Route::get('class-rooms/create', 'ClassRoomsController@create');
    Route::post('class-rooms', 'ClassRoomsController@store');
    Route::get('class-rooms/{classRoom}/edit', 'ClassRoomsController@edit');
    Route::put('class-rooms/{classRoom}', 'ClassRoomsController@update');
    Route::delete('class-rooms/{classRoom}', 'ClassRoomsController@destroy');

    Route::get('/subjects', 'SubjectsController@index');
    Route::get('subjects/create', 'SubjectsController@create');
    Route::post('subjects', 'SubjectsController@store');
    Route::get('subjects/{subject}/edit', 'SubjectsController@edit');
    Route::put('subjects/{subject}', 'SubjectsController@update');
    Route::delete('subjects/{subject}', 'SubjectsController@destroy');

    Route::get('/semesters', 'SemestersController@index');
    Route::get('semesters/create', 'SemestersController@create');
    Route::post('semesters', 'SemestersController@store');
    Route::get('semesters/{semester}/edit', 'SemestersController@edit');
    Route::put('semesters/{semester}', 'SemestersController@update');
    Route::delete('semesters/{semester}', 'SemestersController@destroy');

    Route::get('/class-learns', 'ClassLearnsController@index');
    Route::get('class-learns/create', 'ClassLearnsController@create');
    Route::post('class-learns', 'ClassLearnsController@store');
    Route::get('class-learns/{classLearn}/edit', 'ClassLearnsController@edit');
    Route::put('class-learns/{classLearn}', 'ClassLearnsController@update');
    Route::delete('class-learns/{classLearn}', 'ClassLearnsController@destroy');

    Route::get('/admins', 'AdminsController@index');
    Route::get('admins/create', 'AdminsController@create');
    Route::post('admins', 'AdminsController@store');
    Route::get('admins/{admin}/edit', 'AdminsController@edit');
    Route::put('admins/{admin}', 'AdminsController@update');
    Route::delete('admins/{admin}', 'AdminsController@destroy');
    Route::get('admins/{admin}', 'AdminsController@show');

    Route::get('/pendaftaran', 'PendaftaranController@index')->name('pendaftaran.index');
    Route::get('/pendaftaran/tambah', 'PendaftaranController@createAdmin')->name('pendaftaran.create.admin');
    Route::post('/pendaftaran/tambah', 'PendaftaranController@storeAdmin')->name('pendaftaran.store.admin');
    Route::get('/pendaftaran/{id}/detail', 'PendaftaranController@detail')->name('pendaftaran.detail');
    Route::post('/pendaftaran/{id}/status', 'PendaftaranController@updateStatus')->name('pendaftaran.status');

    Route::get('admin', 'AdminsController@profileAdmin');
    Route::get('admin/edit', 'AdminsController@editAdmin');
    Route::get('/changePassword', 'AuthController@showChangePasswordForm');
    Route::post('/changePassword', 'AuthController@changePassword')->name('changePassword');

    Route::get('/schedules', 'SchedulesController@index');
    Route::get('schedules/{class_id}/{semester_id}/create', 'SchedulesController@create');
    Route::post('schedules', 'SchedulesController@store');
    Route::get('schedules/{schedule}/edit', 'SchedulesController@edit');
    Route::put('schedules/{schedule}', 'SchedulesController@update');
    Route::delete('schedules/{schedule}', 'SchedulesController@destroy');
    Route::get('schedules/class/{schedule}', 'SchedulesController@scheduleClass');

    Route::get('/grades', 'GradesController@index');
    Route::get('grades/{class_id}/{semester_id}/create', 'GradesController@create');
    Route::post('grades', 'GradesController@store');
    Route::get('grades/{grade}/edit', 'GradesController@edit');
    Route::put('grades/{grade}', 'GradesController@update');
    Route::delete('grades/{grade}', 'GradesController@destroy');
    Route::get('grades/{grade}', 'GradesController@show');

    Route::get('/informations', 'InformationsController@index');
    Route::get('informations/create', 'InformationsController@create');
    Route::post('informations', 'InformationsController@store');
    Route::get('informations/{information}/edit', 'InformationsController@edit');
    Route::put('informations/{information}', 'InformationsController@update');
    Route::delete('informations/{information}', 'InformationsController@destroy');
    Route::get('informations/{information}', 'InformationsController@show');

    // Export
    Route::get('export-siswa-pdf', 'ExportsController@exportSiswaPDF');
    Route::get('export-jadwal/{kelas}/{semester}', 'ExportsController@exportJadwalPDF');
    Route::get('export-nilai/{kelas}/{semester}', 'ExportsController@exportNilaiPDF');

    // Ajax
    Route::get('getdatastudents', ['uses' => 'StudentsController@getdatastudent', 'as' => 'ajax.get.data.student']);
    Route::get('getdatateachers', ['uses' => 'TeachersController@getdatateachers', 'as' => 'ajax.get.data.teachers']);
    Route::get('getdataclass', ['uses' => 'ClassRoomsController@getdataclass', 'as' => 'ajax.get.data.class']);
    Route::get('getdatasubject', ['uses' => 'SubjectsController@getdatasubject', 'as' => 'ajax.get.data.subject']);
    Route::get('getdatasemester', ['uses' => 'SemestersController@getdatasemester', 'as' => 'ajax.get.data.semester']);
    Route::get('getdataclassLearn', ['uses' => 'ClassLearnsController@getdataclassLearn', 'as' => 'ajax.get.data.classLearn']);
    Route::get('getdataadmin', ['uses' => 'AdminsController@getdataadmin', 'as' => 'ajax.get.data.admin']);
    Route::get('getdatascheduleclass', ['uses' => 'SchedulesController@getdataclass', 'as' => 'ajax.get.data.scheduleclass']);
    Route::get('/getdataschedules', 'SchedulesController@getCustomFilterDataSchedule');
    Route::get('/getdataschedule/{kelas_id}/{semester_id}', 'SchedulesController@getdataschedule');
    Route::get('getdatainformation', ['uses' => 'InformationsController@getdatainformation', 'as' => 'ajax.get.data.information']);

    // Roles & Permissions
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('role-permission', 'RolePermissionController');
    Route::resource('user-role', 'UserRoleController');
    Route::resource('user-permission', 'UserPermissionController');
});

/*
|--------------------------------------------------------------------------
| SISWA ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'checkRole:siswa'], 'prefix' => 'student'], function () {
    Route::get('/dashboard', 'DashboardController@student');

    Route::get('/dashboard/informations', 'DashboardController@allInformations');
    Route::get('/dashboard/information/{information_id}', 'DashboardController@showInformation');

    Route::get('/profile', 'StudentsController@profileStudent');
    Route::get('/schedules', 'StudentsController@schedulesStudent');
    Route::get('/grades', 'StudentsController@gradesStudent');
    Route::get('/changePassword', 'AuthController@showChangePasswordForm');
    Route::post('/changePassword', 'AuthController@changePassword')->name('changePassword');
    Route::get('/edit-profile', 'StudentsController@editStudent');
    Route::put('/edit/{student}', 'StudentsController@updateStudent');
    Route::get('export-nilai-siswa/{kelas}/{semester}', 'ExportsController@exportNilaiSiswaPDF');
    Route::get('export-jadwal/{kelas}/{semester}', 'ExportsController@exportJadwalPDF');
});

/*
|--------------------------------------------------------------------------
| GURU ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'checkRole:guru'], 'prefix' => 'teacher'], function () {

    Route::get('/dashboard', 'DashboardController@teacher');

    Route::get('/profile', 'TeachersController@profileTeacher');
    Route::get('/edit-profile', 'TeachersController@editProfileTeacher');

    Route::put('/edit/{teacher}', 'TeachersController@updateTeacher');

    Route::get('/schedules', 'TeachersController@schedulesTeacher');

    // NILAI
    Route::get('/grades', 'TeachersController@indexGradeTeacher');
    Route::get('/grades/{class_id}/{semester_id}/create', 'TeachersController@createGradeTeacher');
    Route::post('/grades', 'TeachersController@storeGradeTeacher');

    // EDIT NILAI
    Route::get('/grades/{grade}/edit', 'TeachersController@editGradeTeacher');
    Route::put('/grades/{grade}', 'TeachersController@updateGradeTeacher');

    // WALI KELAS
    Route::get('/homeroom-teacher', 'TeachersController@indexHomeroomTeacher');

    Route::get(
        '/homeroom-teacher/class/{class_id}/semester/{semester_id}',
        'TeachersController@showStudentHomeroomTeacher'
    );

    Route::get(
        '/homeroom-teacher/grades/class-student/{class_student_id}/semester/{semester_id}',
        'TeachersController@showGradeHomeroomTeacher'
    );

    // PASSWORD
    Route::get('/changePassword', 'AuthController@showChangePasswordForm');

    Route::post(
        '/changePassword',
        'AuthController@changePassword'
    )->name('changePassword');

});