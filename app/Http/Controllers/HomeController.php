<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $getSplide = true;

        $courses = [
            (object) [
                'img' => 'piano.png',
                'title' => 'Teclado',
            ],
            (object) [
                'img' => 'sing.png',
                'title' => 'Canto',
            ],
            (object) [
                'img' => 'guitar.png',
                'title' => 'Guitarra',
            ],
            (object) [
                'img' => 'violin.png',
                'title' => 'Violin',
            ],
            (object) [
                'img' => 'guitar.png',
                'title' => 'Cuatro',
            ],
            (object) [
                'img' => 'flute.png',
                'title' => 'Flauta',
            ],
            (object) [
                'img' => 'piano.png',
                'title' => 'Piano',
            ],
            (object) [
                'img' => 'sax.png',
                'title' => 'Saxofón',
            ],
            (object) [
                'img' => 'ukelele.png',
                'title' => 'Ukelele',
            ],
            (object) [
                'img' => 'drums.png',
                'title' => 'Batería',
            ],
            (object) [
                'img' => 'bass.png',
                'title' => 'Bajo',
            ],
            (object) [
                'img' => 'solfeo.png',
                'title' => 'Solfeo',
            ],
            (object) [
                'img' => 'armonia.png',
                'title' => 'Armonía',
            ],
            (object) [
                'img' => 'arpa.png',
                'title' => 'Arpa',
            ],
        ];
        return view('website.home', compact('getSplide', 'courses'));
    }

    public function faq()
    {
        $getSplide = false;
        $faqs = [
            (object) [
                'question' => '¿No se nada de Música, puedo inscribirme?',
                'answer' => 'Si, formamos  estudiantes desde cero en cualquierade nuestras cátedras.'
            ],
                        (object) [
                'question' => '¿No tengo el instrumento, ustedes lo prestan?',
                'answer' => 'Si, durante nuestras clases facilitamos el instrumento para que puedan aprender.'
            ],
            (object) [
                'question' => '¿Cuál es el horario de clases?',
                'answer' => 'Los horarios dependen del instrumento, edad y nivel del estudiante.'
            ],
            (object) [
                'question' => '¿Tengo un niño con autismo puede participar?',
                'answer' => 'Si, todos los niños son bienvenidos a nuestra Academia.'
            ],
            (object) [
                'question' => '¿Dan clases los sábados o domingos?',
                'answer' => 'No, nuestras clases son de lunes a viernes en las tardes.'
            ]
        ];


        return view('website.faq', compact('getSplide', 'faqs'));
    }

    public function about()
    {
        $getSplide = false;
        return view('website.about', compact('getSplide'));
    }
}
