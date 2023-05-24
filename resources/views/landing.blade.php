<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Работа в Пиццамании</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;700&display=swap" rel="stylesheet">
                <!-- Favicon-->
        <link rel="icon" type="image/png" href="/favicon.png" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="assets/css/styles.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />

    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://pizzamania.by/admin/uploads/settings/header-logo.png" style="max-height: 40px" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#benefits">Преимущества</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#calculator">Калькулятор</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#vacancy">Карьера</a></li>
                        <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Вопросы</a></li> -->
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#questions">Контакты</a></li>
                       
                    </ul>
                </div>
                <a href="#contact" class="btn btn-primary orange d-none ms-2 d-lg-inline-block">Заполнить анкету</a>

            </div>
        </nav>
        <section class="main-carousel mt-3 container">
            <div id="mainCarousel" class="carousel slide" data-bs-touch="true" data-bs-interval="3000" data-bs-ride="carousel">
                <div class="carousel-inner">
                @if ($data && isset($data['page']))
                    @if ($data['page']->getMedia('slider')->count() > 0)
                        @foreach ($data['page']->getMedia('slider') as $media)
                        <div class="carousel-item{{ $loop->first ? ' active' : '' }}">
                            <img src="{{ $media->getUrl() }}" class="d-block w-100">
                        </div>
                        @endforeach
                    @endif
                @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Назад</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Вперед</span>
                </button>
            </div>
        </section>
        <section class="benefits mt-5 pt-3 mb-5" id="benefits">
            
      
                
            <div class="container ">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="mb-5 pb-2">Почему люди выбрают Пиццаманию?</h1>
                        @if ($data && isset($data['page']))
                            <?php
                                $about = $data['page']['about'];
                                $paragraphs = preg_split('/<\/?p>/', $about, -1, PREG_SPLIT_NO_EMPTY);
                                foreach ($paragraphs as $paragraph) {
                                    echo '<p class="text">' . $paragraph . '</p>';
                                }
                            ?>
                        @endif
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <div class="row">
                            @if ($data && isset($data['page']))
                                @if ($data['page']->getMedia('benefits')->count() > 0)
                                    @foreach ($data['page']->getMedia('benefits') as $media)
                                    <div class="col-6 mb-3">
                                        <img src="{{ $media->getUrl() }}" class="img-fluid benefits-item">
                                    </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <div class="container pt-5 mb-5" id="calculator">
            <section class="calculator py-5" >
                <div class="container container-mid">
                    <h4 class="text-center mb-1 text-primary">Калькулятор</h4>
                    <h1 class="text-center mb-5">Узнать уровень заработной платы</h1>
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="mb-4">
                                <p class="mb-2 calculator-text"><b>Ресторан</b>, в котором я хочу работать</p>
                                
                                @if ($data && isset($data['restaurants']))
                                    <select id="calc-rest" class="form-select">
                                        <option selected disabled>Выбрать ресторан</option>
                                        @foreach ($data['restaurants'] as $restaurant)
                                            <?php 
                                                $vacancies = [];
                                                foreach ($restaurant['vacancies'] as $vacancy) {
                                                    $vacancies[] = [
                                                        'name' => $vacancy['name'],
                                                        'price_per_hour' => $vacancy['pivot']['price_per_hour'],
                                                    ];
                                                }
                                                $vacancies = json_encode($vacancies);
                                            ?>
                                            <option value="{{ $vacancies }}">{{ $restaurant['name'] }}</option>
                                        @endforeach
                                    </select>
                                @endif

                            </div>
                            <div class="mb-4">
                                <p class="mb-2 calculator-text" ><b>Вакансия</b>, по которой я хочу работать</p>
                                <select id="calc-vac" class="form-select" disabled>
                                    <option selected disabled>Выбрать вакансию</option>
                                </select>
                            </div>
                            <div class="mb-4" id="calc-num-field">
                                <p class="mb-2 calculator-text" >Сколько <b>рабочих часов</b> я планирую отработать в неделю?</p>
                                <input id="calc-num" type="number" disabled class="form-control" value="40">
                                <span class="text-danger">Минимальное количество рабочих часов в неделю – 9,5. Максимальное - 40</span>
                            </div>
                            <a href="" id="calculate" class="btn btn-lg btn-primary orange w-100 disabled" disabled> Рассчитать</a>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-none h-100" id="calculations">
                                <div class="calculator-result p-3 d-flex flex-column text-center align-items-center justify-content-center">
                                    <p class="text mb-4">Твоя заработная плата может составить:</p>
                                    <div class="fw-bold text-primary"><span class="h1" id="calc-result">1200</span> <br class="d-lg-none"><span class="h5">руб./месяц</span></div>
                                </div>
                            </div>
                            <div class="h-100" id="calculations-prepare">
                                <div class="calculator-result text-secondary p-3 d-flex flex-column text-center align-items-center justify-content-center">
                                    <p class="text mb-4">Заполни форму и нажми <span class="text-primary">Рассчитать</span>, чтобы узнать сколько может составить твоя заработная плата</p>
                                  </div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>

        <section class="vacancy pt-5 mb-5" id="vacancy">
            <div class="container">
                <h1 class="mb-5">Кем можно работать у нас?</h1>

                <div class="vacancy-roll" role="tablist">
                    @foreach ($data['vacancies'] as $index => $vacancy)
                        <div class="vacancy-roll-item {{ $index == 0 ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#vacancy-{{ $vacancy->id }}" type="button" role="tab">
                        @if(isset($vacancy->media) && count($vacancy->media) > 0)
                            <img class="img-fluid" src="{{ $vacancy->media[0]->getUrl('preview') }}" alt="{{ $vacancy->name }}">
                        @endif
                            <p class="vacancy-roll-item-text">{{ $vacancy->name }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="vacancy-tabs mt-3">
                    @foreach ($data['vacancies'] as $key => $vacancy)
                        <div class="vacancy-tab fade {{ $key === 0 ? 'show active' : '' }}" id="vacancy-{{ $vacancy['id'] }}">
                            <div class="container-mid">
                                <h3 class="mb-3 mt-3 fw-bold">{{ $vacancy['name'] }}</h3>

                                {!! $vacancy['description'] !!}

                                <div class="mt-4"></div>
                                <a href="#contact" class="btn btn-primary orange btn-lg">Заполнить анкету</a>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>
        </section>
        
        <section class="contact pt-5 mb-5" id="contact">
            <div class="container">
                <h1 class="mb-5">Заполните анкету</h1>
                <form action="" id="form">
                    <div class="row">

                        <div class="col-lg-5">
                            <div class="mb-4">
                                <!-- <p class="mb-2">Ресторан</p> -->
                                @if ($data && isset($data['restaurants']))
                                    <select required id="cont-rest" class="form-select" name="rest">
                                        <option value="" selected disabled>Выбрать ресторан</option>
                                        @foreach ($data['restaurants'] as $restaurant)
                                            <?php 
                                                $vacancies = [];
                                                foreach ($restaurant['vacancies'] as $vacancy) {
                                                    $vacancies[] = [
                                                        'id' => $vacancy['id'],
                                                        'rest_id' => $restaurant['id'],
                                                        'name' => $vacancy['name'],
                                                        'price_per_hour' => $vacancy['pivot']['price_per_hour'],
                                                    ];
                                                }
                                                $vacancies = json_encode($vacancies);
                                            ?>
                                            <option value="{{ $vacancies }}">{{ $restaurant['name'] }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="mb-4">
                                <!-- <p class="mb-2 " >Вакансия</p> -->
                                <select id="cont-vac" class="form-select" name="vac" required disabled>
                                    <option value="" selected disabled>Выбрать вакансию</option>
                                </select>
                            </div>
                            
                        </div>   
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <input type="text" required name="name" placeholder="Имя" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-4">
                                        <input type="text" required name="surname" placeholder="Фамилия" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <input type="text" required name="birthday"  id="birthday" placeholder="День рождения" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <input type="text" required name="phone" id="phone" placeholder="Телефон" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <input type="text" name="social" placeholder="Ссылка на соцсеть" class="form-control mb-2">
                                <p class="mb-0 text-secondary">По желанию. На случай, если не дозвонимся по телефону.</p>
                            </div>
                        
                            
                        </div> 
                    </div>

                    <button type="submit" class="col-lg-4 btn btn-lg btn-primary orange mb-3">Отправить</button>
                    <p class="mb-0 text-secondary">Согласен на  обработку персональных данных</p>

                </form>
                
            </div>
        </section>

        <section class="questions pt-5 mb-5 pb-5" id="questions">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <h1 class="mb-4">Остались вопросы?</h1>
                        <p class="text">
                            Здесь мы собрали самые популярные.<br>
                            Если не нашли свой вопрос, напишите нам на почту:<br><br>
                            @if ($data && isset($data['page']))
                                <a href="mailto:{{ $data['page']->email }}" class="text-primary">{{ $data['page']->email }}</a>
                                <br>
                                Или звоните по телефону:<br>
                                <a href="tel:{{ $data['page']->phone }}" class="text-primary">{{ $data['page']->phone }}</a>
                            @endif


                        </p>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion" id="accordion-qna">
                            @foreach (json_decode($data['page']['questions'], true) as $index => $question)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="qna-heading-{{ $index }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qna-collapse-{{ $index }}" aria-expanded="false" aria-controls="qna-collapse-{{ $index }}">
                                            {{ $question['name'] }}
                                        </button>
                                    </h2>
                                    <div id="qna-collapse-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="qna-heading-{{ $index }}" data-bs-parent="#accordion-qna">
                                        <div class="accordion-body">{!! $question['answer'] !!}</div>
                                    </div>
                                </div>
                            @endforeach
                            
                          </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Отправлено успешно</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ваша заявка успешно отправлена.
                </div>
                </div>
            </div>
        </div>


        

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
