<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма связи</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/contact_form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<section class="hero-section">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-6">
                <div class="form-card">
                    <h3 class="mb-3 text-white">Szukasz najlepszej oferty?</h3>
                    <p class="text-white mb-4">
                        Zostaw aplikację, a nasz menedżer skontaktuje się z Tobą.
                    </p>

                    <div id="successMessage" class="alert alert-success" style="display:none;">
                        Udało się wysłać formularz
                    </div>

                    <form id="contactForm" autocomplete="off">
                        <div class="row form-gap">
                            <div class="col-12 col-md-4">
                                <input id="first_name" name="first_name" type="text"
                                       class="form-control" placeholder="Twoje imię">
                            </div>

                            <div class="col-12 col-md-4">
                                <input id="last_name" name="last_name" type="text"
                                       class="form-control" placeholder="Twoje nazwisko">
                            </div>

                            <div class="col-12 col-md-4">
                                <input id="middle_name" name="middle_name" type="text"
                                       class="form-control" placeholder="Twoje drugie imię">
                            </div>

                            <div class="col-12">
                                <input type="date" id="birth_date" name="birth_date" class="form-control">
                            </div>

                            <div class="col-12">
                                <input id="email" name="email" type="email"
                                       class="form-control" placeholder="E-mail">
                            </div>

                            <div class="col-12">
                                <div class="phone-block">
                                    <div class="phone-placeholder" id="phonePlaceholder">
                                        <span>Telefon</span>
                                        <button type="button" class="btn-add-phone" id="openPhone">+</button>
                                    </div>

                                    <div class="phone-list d-none" id="phoneList">
                                        <div class="phone-row">
                                            <div class="country-select">
                                                <div class="country-current" id="countryToggle">
                                                    <img class="current-flag" src="/images/belarus.svg" alt="">
                                                    <img class="arrow" src="/images/arrow.svg" alt="">
                                                </div>

                                                <div class="country-panel">
                                                    <span class="country-title">Wybierz swój kraj</span>

                                                    <label class="country-option">
                                                        <input type="radio" name="country_code" value="+375" checked>
                                                        <img src="/images/belarus.svg">
                                                    </label>

                                                    <label class="country-option">
                                                        <input type="radio" name="country_code" value="+7">
                                                        <img src="/images/russia.svg">
                                                    </label>
                                                </div>
                                            </div>

                                            <input type="tel" class="form-control phone-input">
                                            <button type="button" class="btn-add-phone add-more">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 radio-select">
                                <div class="selectBox" onclick="toggleRadios()">
                                    Stan cywilny
                                    <img class="arrow" src="/images/arrow.svg" alt="">
                                </div>
                                <div class="radio-group" id="radioOptions">
                                    <label><input type="radio" name="marital_status" value="single"><span>Samotny/niezamężny</span></label>
                                    <label><input type="radio" name="marital_status" value="married"><span>Żonaty</span></label>
                                    <label><input type="radio" name="marital_status" value="divorced"><span>Rozwiedziony</span></label>
                                    <label><input type="radio" name="marital_status" value="widowed"><span>Wdowiec/wdowa</span></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <textarea id="about" name="about"
                                          class="form-control"
                                          rows="1"
                                          placeholder="O mnie"></textarea>
                            </div>

                            <div class="col-12 d-flex align-items-center justify-content-between">
                                <div class="form-check mb-0">
                                    <input id="agreed" name="agreed" class="form-check-input" type="checkbox">
                                    <label for="agreed" class="form-check-label text-light mb-0">
                                        Przeczytałem zasady
                                    </label>
                                </div>

                                <button type="submit" id="submitBtn" class="btn btn-submit" disabled>
                                    Wyślij
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="/js/contact_form.js"></script>
</body>
</html>
