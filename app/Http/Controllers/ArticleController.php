<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; // Asumiendo que tienes un modelo Article
use Parsedown;

class ArticleController extends Controller
{
    private $viewDirectory;
    private $replacements; // Variable global para palabras clave
    private $normalizedReplacements;

    public function __construct()
    {
        // Obtén la variable de entorno
        $this->viewDirectory = env('VIEW_DIRECTORY');

        $this->replacements = [
            'Carta Astral',
            'horóscopo',
            'Zodiacales',
            'decisiones?',
            'Carta Astral Gratis',
            'Horoscopo Chino',
            'Capricórnio',
            'Horóscopo de Hoy',
            'emociones',
            'Mercurio Retrogrado',
            'Soñar con Ratas',
            'Piscis Hoy',
            'Suerte',
            'Escorpio',
            'Signo Leo',
            'Virgo Hoy',
            'Tauro Hoy',
            'Libra Hoy',
            'Capricornio Hoy',
            'Sagitário Hoy',
            'Acuario Hoy',
            'Signos',
            'Piscis',
            'Astrología',
            'Compatibilidad de Signos',
            'Cáncer Hoy',
            'Fechas de los Signos',
            'Horoscopo Leo',
            'Personalidad',
            'Sueños',
            'Influencia de los Signos Zodiacales',
            'Personalidad',
            'Política de Privacidad',
            'Términos y Condiciones',
            'Preguntas Frecuentes',
            'Influencia de los Sueños',
            'Suerte',
            'Horóscopo',
            'Tomar Mejores Decisiones',
            'Luna',
            'Emociones',
            'Vida',
            'Aries',
            'Primer Signo del Zodiaco',
            'Energía de Aries',
            'Tauro',
            'Estabilidad',
            'Paciencia',
            'Fortaleza',
            'Géminis',
            'Dualidad',
            'Comunicación',
            'Adaptabilidad',
            'Cáncer',
            'Signo del Hogar',
            'Emoción',
            'Protección',
            'Leo',
            'Signo del Coraje',
            'Confianza',
            'Creatividad',
            'Virgo',
            'Signo de la Organización',
            'Práctica',
            'Perfección',
            'Libra',
            'Signo de la Armonía',
            'Diplomacia',
            'Encanto',
            'Escorpio',
            'Signo de la Intensidad',
            'Transformación',
            'Misterio',
            'Sagitario',
            'Signo de la Aventura',
            'Libertad',
            'Filosofía',
            'Capricornio',
            'Signo de la Disciplina',
            'Ambición',
            'Perseverancia',
            'Acuario',
            'Signo de la Innovación',
            'Independencia',
            'Revolución',
        ];

        // Optimización: Pre-calcular normalizaciones para búsqueda rápida O(1)
        $this->normalizedReplacements = [];
        foreach ($this->replacements as $r) {
            $normalized = strtolower(preg_replace('/[^\w]+/', '', $r));
            if ($normalized !== '') {
                $this->normalizedReplacements[$normalized] = true;
            }
        }
    }

    private function applyReplacements($text)
    {
        // Dividir el texto en palabras y revisar cada una
        $words = preg_split('/(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $output = '';
        $em = true;

        foreach ($words as $word) {
            // Remover espacios y normalizar para comparar
            $trimmedWord = trim($word);

            // Convertir la palabra a minúsculas y eliminar signos para la comparación
            $normalizedWord = strtolower(preg_replace('/[^\w]+/', '', $trimmedWord));

            // Optimización: Búsqueda O(1) en el mapa pre-calculado
            if ($normalizedWord !== '' && isset($this->normalizedReplacements[$normalizedWord])) {
                // Si hay coincidencia, resalta la palabra original
                if ($em) {
                    $output .= "<em>$trimmedWord</em>";
                    $em = false;
                } else {
                    $output .= "<span>$trimmedWord</span>";
                    $em = true;
                }
            } else {
                $output .= $word;
            }
        }

        return $output;
    }



    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);

        // Aplicar reemplazos en los títulos de todos los artículos
        foreach ($articles as $article) {
            $article->title = $this->applyReplacements($article->title);
        }

        return view('mihoroscopo/articles.index', compact('articles'));
    }


    public function show($slug)
    {

        $article = Article::where('slug', $slug)->firstOrFail();
        $parsedown = new Parsedown();
        $article->content = $parsedown->text($article->content);
        return view('mihoroscopo/articles.show', compact('article'));
    }


    // Muestra la lista de artículos en el panel de administración
    public function adminIndex()
    {

        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }






    // Mostrar el formulario para crear un nuevo artículo
    public function create()
    {
        return view('admin.articles.create');
    }

    // Guardar el nuevo artículo
    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:articles',
            'title' => 'required',
            'content' => 'required',
        ]);

        Article::create($request->all());
        return redirect()->route('articles.index')->with('success', 'Artículo creado exitosamente.');
    }

    // Mostrar el formulario para editar un artículo
    public function edit(Article $article)
    {


        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'id' => 'required|exists:articles,id', // Asegura que el ID es válido y el artículo existe
            'slug' => 'required|unique:articles,slug,' . $request->input('id'),
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Capturar el artículo utilizando el ID del request
        $article = Article::findOrFail($request->input('id'));

        // Preparar los datos para la actualización
        $update = [
            'slug' => $request->input('slug'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];

        // Actualizar el artículo
        $article->update($update);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.articles.edit', $article->id)->with('success', 'Artículo actualizado exitosamente.');
    }



    // Eliminar un artículo
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artículo eliminado exitosamente.');
    }
}
