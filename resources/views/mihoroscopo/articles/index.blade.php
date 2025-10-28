
    @extends('mihoroscopo.layouts.app')

    @section('title', 'Artículos - Mi Sitio Web')




    @section('content')

    <div class="main-banner">
        <div class="container">
          <div class="row">
            <div class="col-lg-7 align-self-center">
              <div class="caption  header-text">

                <h2>Artículos</h2>
                <div class="line-dec"></div>
                {{-- <h4>Most Frequently Asked <em>Questions</em> Here <em>?</em></h4> --}}
                <h4>Explora los últimos temas sobre <em>astrología</em> y el <em>zodiaco</em></h4>



                </div>
            </div>

          </div>
        </div>



      </div>


      <main>
        <section>
            <ul>

                    <div class="container"> @foreach ($articles as $article)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="section-heading">
                                    <a href="blog/{!! $article->slug !!}"><h2>{!! $article->title !!}</h2></a>
                                    <div class="line-dec"></div>
                                </div>
                            </div>
                        </div>  @endforeach
  {{ $articles->links() }}
                    </div>

                {{-- <div class="pagination"> --}}

                {{-- </div> --}}
            </ul>

            {{-- Enlaces de paginación --}}

        </section>
    </main>


    @endsection

