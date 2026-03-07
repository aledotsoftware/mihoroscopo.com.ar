<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request; // Asumiendo que tienes un modelo Article
use Illuminate\Support\Facades\Cache;
use Parsedown;

class ArticleController extends Controller
{
    private $viewDirectory;

    private $replacementPattern; // Patrón regex pre-calculado

    const CACHE_VERSION = 'v1';

    public function __construct()
    {
        // Obtén la variable de entorno
        $this->viewDirectory = env('VIEW_DIRECTORY');
    }

    private function getReplacementPattern()
    {
        if ($this->replacementPattern !== null) {
            return $this->replacementPattern;
        }

        $this->replacementPattern = Cache::rememberForever('article_replacements_' . self::CACHE_VERSION, function () {
            $replacements = [
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

            // Optimización: Pre-calcular patrón regex para búsqueda rápida y soporte de frases
            // Ordenar por longitud descendente para que las frases más largas se encuentren primero
            usort($replacements, function ($a, $b) {
                return strlen($b) - strlen($a);
            });

            $patterns = [];
            foreach ($replacements as $r) {
                $escaped = preg_quote($r, '/');
                // Agregar límites de palabra solo si empieza/termina con un carácter de palabra (Unicode)
                $start = preg_match('/^\w/u', $r) ? '\b' : '';
                $end = preg_match('/\w$/u', $r) ? '\b' : '';
                $patterns[] = $start.$escaped.$end;
            }

            return '/('.implode('|', $patterns).')/iu';
        });

        return $this->replacementPattern;
    }

    private function applyReplacements($text)
    {
        // Optimización: Usar preg_replace_callback con el patrón pre-calculado
        // Esto evita iterar palabra por palabra y soporta frases de varias palabras
        $em = true;

        return preg_replace_callback($this->getReplacementPattern(), function ($matches) use (&$em) {
            $word = $matches[0];
            if ($em) {
                $em = false;

                return "<em>$word</em>";
            } else {
                $em = true;

                return "<span>$word</span>";
            }
        }, $text);
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

        // ⚡ Bolt: CPU/Memory optimization.
        // What: Added caching to the Parsedown markdown compilation process.
        // Why: Parsing raw markdown to HTML on every page load for static content is an expensive, synchronous CPU operation.
        //      The cache key uses the `updated_at` timestamp to automatically invalidate when the article is updated, avoiding expensive string hashing.
        // Impact: Eliminates redundant parsing cycles per request, significantly speeding up article rendering.
        $cacheKey = 'article_parsed_' . $article->id . '_' . ($article->updated_at?->timestamp ?? 0);
        $article->content = Cache::remember($cacheKey, 86400, function () use ($article) {
            $parsedown = new Parsedown;
            return $parsedown->text($article->content);
        });

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
            'slug' => 'required|unique:articles,slug,'.$request->input('id'),
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
