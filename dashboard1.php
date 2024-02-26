<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="">
    <style type="text/css">
    html {
        box-sizing: border-box;
        font-size: 62.5%;
        /* Set base font size to 10px */
    }

    .booking-bar__inputs .icon-input:not(:last-of-type) {
        margin-right: 1rem;
    }

    @media only screen and (max-width: 768px) {
        html {
            font-size: 56.25%;
            /* Adjust base font size for smaller screens */
        }

        .container {
            padding: 0 2rem;
        }

        .dashboard {
            grid-template-columns: 1fr;
        }

        .dashboard .booking-bar,
        .dashboard .flights,
        .dashboard .user-card,
        .dashboard .sidebar {
            grid-column: 1 / -1;
        }

        .booking-bar {
            padding: 2rem;
        }

        .booking-bar__inputs {
            flex-direction: column;
            align-items: flex-start;
        }

        .booking-bar__inputs .icon-input:not(:last-of-type) {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .top-flights {
            flex-direction: column;
            margin-bottom: 2rem;
        }

        .top-flight-card {
            margin-bottom: 1rem;
        }

        .flight-card {
            flex-direction: column;
            padding: 2rem;
        }

        .flight-card__airlines {
            margin-bottom: 1rem;
        }
    }

    :root {
        --color-off-white: 240, 18%, 97%;
        --color-purple: 239, 39%, 45%;
        --color-light-purple: 240, 52%, 94%;
        --color-orange: 13, 94%, 66%;
        --color-dark-orange: 13, 94%, 46%;
        --font-weight-normal: 400;
        --font-weight-medium: 600;
        --font-weight-bold: 700;
        --ease-out-quart: cubic-bezier(0.25, 1, 0.5, 1);
    }

    html {
        box-sizing: border-box;
        font-size: 10px;
    }

    *,
    *::before,
    *::after {
        box-sizing: inherit;
    }

    body {
        font-family: poppins, sans-serif;
        font-size: 1.6rem;
        color: HSL(var(--color-purple));
        text-rendering: optimizeLegibility;
    }

    body,
    input,
    button {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    img {
        display: block;
        max-width: 100%;
    }

    .container {
        margin: 4rem auto;
        width: 130rem;
        padding: 0 4rem;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        grid-template-rows: auto auto;
        grid-gap: 3rem;
    }

    .dashboard .booking-bar,
    .dashboard .flights {
        grid-column: 1/10;
    }

    .dashboard .user-card,
    .dashboard .sidebar {
        grid-column: 10/-1;
    }

    .dashboard .sidebar {
        align-self: start;
    }

    .dashboard .user-card {
        grid-row: 1/1;
    }

    input[type="text"],
    input[type="search"],
    input[type="email"],
    input[type="phone"] {
        border-radius: 0.6rem;
        padding: 1em 1em;
        border: none;
        color: HSL(var(--color-purple));
    }

    .icon-input {
        position: relative;
    }

    .icon-input__icon {
        position: absolute;
        left: 0.5em;
        top: 50%;
        color: HSL(var(--color-purple));
        transform: translateY(-50%);
    }

    .icon-input input {
        padding-left: 3em;
    }

    .checkbox {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }

    .checkbox+label {
        position: relative;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .checkbox+label::before {
        border-radius: 0.8rem;
        content: '';
        display: inline-block;
        margin-right: 1rem;
        background-color: HSL(var(--color-light-purple));
        width: 2.5rem;
        height: 2.5rem;
        vertical-align: text-top;
        transition: 0.5s background-color var(--ease-out-quart);
    }

    .checkbox+label::after {
        display: inline-block;
        position: absolute;
        left: 0.6rem;
        top: 0.7rem;
        font-size: 1.2rem;
        font-family: 'Font Awesome 5 Pro';
        font-weight: 600;
        color: #fff;
        content: "\f00c";
        visibility: hidden;
    }

    .checkbox:hover+label::before {
        background-color: HSL(var(--color-purple));
    }

    .checkbox:checked+label::before {
        background-color: HSL(var(--color-purple));
    }

    .checkbox:checked+label::after {
        visibility: visible;
    }

    .button {
        border-radius: 0.8rem;
        padding: 0.75em 2em;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-color: HSL(var(--button-background-color, var(--color-orange)));
        color: HSL(var(--button-text-color, 0, 0%, 100%));
        font-size: 1.8rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.7s var(--ease-out-quart), color 0.7s var(--ease-out-quart);
    }

    .button:hover {
        background-color: HSL(var(--button-hover-background-color, var(--color-dark-orange)));
        color: HSL(var(--button-hover-text-color, 0, 0%, 100%));
    }

    .button--purple {
        --button-background-color: var(--color-light-purple);
        --button-text-color: var(--color-purple);
        --button-hover-background-color: var(--color-purple);
    }

    .choice-list__item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .choice-list__item:not(:last-child) {
        margin-bottom: 1rem;
    }

    .choice-list__aside {
        font-size: 1.4rem;
    }

    .styled-price {
        font-size: 4rem;
        font-weight: var(--font-weight-medium);
    }

    .styled-price sup {
        vertical-align: top;
        font-size: 1.5rem;
        font-weight: var(--font-weight-normal);
    }

    .styled-price sub {
        vertical-align: bottom;
        font-size: 1.2rem;
        font-weight: var(--font-weight-normal);
    }

    .route-line {
        position: relative;
        margin: 1rem 0 0;
        width: 100%;
        height: 1px;
        border: 0.1rem dashed HSL(var(--color-purple));
    }

    .route-line__stop {
        border-radius: 100%;
        box-sizing: content-box;
        width: 0.8rem;
        height: 0.8rem;
        position: absolute;
        top: 50%;
        background-color: HSL(var(--color-purple));
        transform: translate3d(-50%, -50%, 0);
    }

    .route-line__stop-name {
        margin-top: 1.5rem;
        font-size: 1.4rem;
        transform: translateX(-0.7rem);
    }

    .route-line__start {
        left: 0;
        border: 0.6rem solid HSL(var(--color-purple));
        background-color: #fff;
    }

    .route-line__end {
        right: 0;
        border: 0.6rem solid HSL(var(--color-light-purple));
        transform: translate3d(50%, -50%, 0);
    }

    .booking-bar {
        border-radius: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 3rem;
        background-color: HSL(var(--color-purple));
        color: #fff;
    }

    .booking-bar__inputs {
        display: flex;
        align-items: center;
    }

    .booking-bar__inputs .icon-input:not(:last-of-type) {
        margin-right: 2rem;
    }

    .booking-bar__heading {
        margin-bottom: 0.8rem;
        font-size: 1.8rem;
        font-weight: var(--font-weight-medium);
        letter-spacing: 0.05rem;
    }

    .booking-bar__sub-heading {
        font-size: 1.4rem;
        letter-spacing: 0.05rem;
    }

    .user-card {
        border-radius: 1.5rem;
        box-shadow: 0 0 0.1rem HSLA(var(--color-purple), 0.1);
        display: flex;
        align-items: center;
        padding: 2rem;
        background-color: #fff;
    }

    .user-card__avatar {
        border-radius: 100%;
        overflow: hidden;
        margin-right: 2rem;
    }

    .user-card__heading {
        line-height: 1.25;
        font-size: 1.5rem;
    }

    .user-card__name {
        display: block;
        font-weight: 600;
    }

    .flights__total {
        margin-bottom: 1rem;
        font-weight: var(--font-weight-medium);
    }

    .flights__total span {
        font-size: 1.3rem;
    }

    .top-flights {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3rem;
    }

    .top-flights .top-flight-card:not(:last-child) {
        margin-right: 2rem;
    }

    .top-flight-card {
        border-radius: 1.5rem;
        box-shadow: 0 0 0.1rem HSLA(var(--color-purple), 0.1);
        display: flex;
        padding: 2rem;
        background-color: #fff;
        cursor: pointer;
        transition: 0.6s var(--ease-out-quart);
    }

    .top-flight-card__price {
        margin-right: 1.5rem;
    }

    .top-flight-card__heading {
        margin-bottom: 0.4rem;
        font-weight: var(--font-weight-medium);
    }

    .top-flight-card__sub-heading {
        font-size: 1rem;
    }

    .top-flight-card.is-active,
    .top-flight-card:hover {
        background-color: HSL(var(--color-purple));
        color: #fff;
    }

    .flights-list__item:not(:last-child) {
        margin-bottom: 2.5rem;
    }

    .flight-card {
        border-radius: 1.5rem;
        box-shadow: 0 0 0.1rem HSLA(var(--color-purple), 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 3rem;
        background-color: #fff;
    }

    .flight-card__airline {
        border-radius: 100%;
        overflow: hidden;
        flex: 0 1 5rem;
        border: 0.2rem solid #fff;
    }

    .flight-card__airline+.flight-card__airline {
        position: relative;
        top: -1.5rem;
    }

    .flight-card__departure {
        margin-left: 2rem;
    }

    .flight-card__arrival {
        margin-right: 3rem;
        text-align: right;
    }

    .flight-card__route {
        display: flex;
        flex-direction: column;
        flex: 1 0 auto;
        justify-content: center;
        align-items: center;
        padding: 0 4rem;
    }

    .flight-card__duration,
    .flight-card__type {
        font-size: 1.4rem;
    }

    .flight-card__type {
        margin-top: 1rem;
    }

    .flight-card__action {
        text-align: center;
    }

    .flight-card__time {
        display: inline-block;
        margin-bottom: 0.8rem;
        font-size: 2rem;
        font-weight: var(--font-weight-medium);
    }

    .flight-card__city {
        margin-bottom: 0.4rem;
        font-size: 1.8rem;
    }

    .flight-card__day {
        font-size: 1.4rem;
    }

    .flight-card__price {
        margin-bottom: 1rem;
    }

    .flight-card__cta {
        min-width: 16rem;
    }

    .sidebar {
        box-shadow: 0 0 0.1rem HSLA(var(--color-purple), 0.1);
        border-radius: 1.5rem;
        margin-top: 2.6rem;
        padding: 3rem 2rem;
        background-color: #fff;
    }

    .sidebar__action {
        width: 100%;
    }

    .sidebar-section:not(:last-child) {
        margin-bottom: 4rem;
    }

    .sidebar-section__heading {
        margin-bottom: 1.5rem;
        font-size: 2.2rem;
        font-weight: var(--font-weight-medium);
    }
    </style>

</head>

<body>
    <div class="container">
        <!-- Your existing content here -->
        <!-- Example: -->
        <main>
            <div class="container">
                <section class="dashboard">
                    <header class="booking-bar">
                        <div class="booking-bar__info">
                            <h2 class="booking-bar__heading">Barcelona (BCN) - Rome (ROM)</h2>
                            <p class="booking-bar__sub-heading">1 adult - Economy</p>
                        </div>
                        <!-- /.booking-bar__info -->
                        <div class="booking-bar__inputs">
                            <div class="icon-input">
                                <i class="icon-input__icon far fa-calendar-alt"></i>
                                <input type="text" placeholder="Departure Date" value="Thursday, April 2">
                            </div>
                            <div class="icon-input">
                                <i class="icon-input__icon far fa-calendar-alt"></i>
                                <input type="text" placeholder="Return Date">
                            </div>
                        </div>
                        <!-- booking-bar__inputs -->
                    </header>

                    <section class="flights">
                        <header>
                            <p class="flights__total">183 <span>results</span></p>
                            <section class="top-flights">
                                <div class="top-flight-card">
                                    <p class="top-flight-card__price styled-price"><sup>$</sup>34</p>
                                    <div class="top-flight-card__info">
                                        <p class="top-flight-card__heading">Cheapest</p>
                                        <p class="top-flight-card__sub-heading">2h 37m average</p>
                                    </div>
                                </div>
                                <!-- /.top-flight-card -->
                                <div class="top-flight-card is-active">
                                    <p class="top-flight-card__price styled-price"><sup>$</sup>56</p>
                                    <div class="top-flight-card__info">
                                        <p class="top-flight-card__heading">Best</p>
                                        <p class="top-flight-card__sub-heading">1h 50m average</p>
                                    </div>
                                    <!-- /.top-flight-card__info -->
                                </div>
                                <!-- /.top-flight-card -->
                                <div class="top-flight-card">
                                    <p class="top-flight-card__price styled-price"><sup>$</sup>93</p>
                                    <div class="top-flight-card__info">
                                        <p class="top-flight-card__heading">Fastest</p>
                                        <p class="top-flight-card__sub-heading">1h 27m average</p>
                                    </div>
                                    <!-- /.top-flight-card__info -->
                                </div>
                                <!-- /.top-flight-card -->
                                <div class="top-flight-card">
                                    <p class="top-flight-card__price styled-price"><sup>$</sup>58</p>
                                    <div class="top-flight-card__info">
                                        <p class="top-flight-card__heading">Fly Greener</p>
                                        <p class="top-flight-card__sub-heading">2h 42m average</p>
                                    </div>
                                    <!-- /.top-flight-card__info -->
                                </div>
                                <!-- /.top-flight-card -->
                            </section>
                        </header>

                        <section class="flights-list">
                            <article class="flight-card flights-list__item">
                                <div class="flight-card__airlines">
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                </div>
                                <!-- /.flight-card__airlines -->
                                <div class="flight-card__departure">
                                    <time class="flight-card__time">10:30 AM</time>
                                    <h2 class="flight-card__city">Barcelona</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__departure -->
                                <div class="flight-card__route">
                                    <p class="flight-card__duration">1hr 50m</p>
                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                        <div class="route-line__stop route-line__start" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop route-line__end" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                    </div>
                                    <!-- flight-card__route-line -->
                                    <p class="flight-card__type">Non-stop</p>
                                </div>
                                <div class="flight-card__arrival">
                                    <time class="flight-card__time">10:30 AM</time>
                                    <h2 class="flight-card__city">Rome</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__arrival -->
                                <div class="flight-card__action">
                                    <p class="flight-card__price styled-price"><sup>$</sup>93<sub>USD</sub></p>
                                    <button class="flight-card__cta button button--orange">Select</button>
                                </div>
                                <!-- /.flight-card__action -->
                            </article>
                            <!-- /.flight-card -->
                            <article class="flight-card flights-list__item">
                                <div class="flight-card__airlines">
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                </div>
                                <!-- /.flight-card__airlines -->
                                <div class="flight-card__departure">
                                    <time class="flight-card__time">7:45 AM</time>
                                    <h2 class="flight-card__city">Barcelona</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__departure -->
                                <div class="flight-card__route">
                                    <p class="flight-card__duration">7hr 55m</p>
                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                        <div class="route-line__stop route-line__start" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop route-line__end" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop" aria-hidden="true" style="left: 50%">
                                            <p class="route-line__stop-name">VIE</p>
                                        </div>
                                    </div>
                                    <!-- flight-card__route-line -->
                                </div>
                                <div class="flight-card__arrival">
                                    <time class="flight-card__time">3:40PM</time>
                                    <h2 class="flight-card__city">Rome</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__arrival -->
                                <div class="flight-card__action">
                                    <p class="flight-card__price styled-price"><sup>$</sup>68<sub>USD</sub></p>
                                    <button class="flight-card__cta button button--orange">Select</button>
                                </div>
                                <!-- /.flight-card__action -->
                            </article>
                            <!-- /.flight-card -->
                            <article class="flight-card flights-list__item">
                                <div class="flight-card__airlines">
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                </div>
                                <!-- /.flight-card__airlines -->
                                <div class="flight-card__departure">
                                    <time class="flight-card__time">10:35 AM</time>
                                    <h2 class="flight-card__city">Barcelona</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__departure -->
                                <div class="flight-card__route">
                                    <p class="flight-card__duration">17hr 15m</p>
                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                        <div class="route-line__stop route-line__start" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop route-line__end" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop" aria-hidden="true" style="left: 25%">
                                            <p class="route-line__stop-name">PMI</p>
                                        </div>
                                        <!-- /.route-line__stop -->
                                        <div class="route-line__stop" aria-hidden="true" style="left: 75%">
                                            <p class="route-line__stop-name">VLC</p>
                                        </div>
                                        <!-- /.route-line__stop -->
                                    </div>
                                    <!-- flight-card__route-line -->
                                </div>
                                <div class="flight-card__arrival">
                                    <time class="flight-card__time">3:50PM</time>
                                    <h2 class="flight-card__city">Rome</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__arrival -->
                                <div class="flight-card__action">
                                    <p class="flight-card__price styled-price"><sup>$</sup>82<sub>USD</sub></p>
                                    <button class="flight-card__cta button button--orange">Select</button>
                                </div>
                                <!-- /.flight-card__action -->
                            </article>
                            <!-- /.flight-card -->
                            <article class="flight-card flights-list__item">
                                <div class="flight-card__airlines">
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                    <div class="flight-card__airline">
                                        <img src="//unsplash.it/30/30" alt="">
                                    </div>
                                    <!-- /.flight-card__airline -->
                                </div>
                                <!-- /.flight-card__airlines -->
                                <div class="flight-card__departure">
                                    <time class="flight-card__time">9:30 AM</time>
                                    <h2 class="flight-card__city">Barcelona</h2>
                                    <time class="flight-card__day">Tuesday, Apr 21, 2020</time>
                                </div>
                                <!-- /.flight-card__departure -->
                                <div class="flight-card__route">
                                    <p class="flight-card__duration">14hr 25m</p>
                                    <div class="flight-card__route-line route-line" aria-hidden="true">
                                        <div class="route-line__stop route-line__start" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop route-line__end" aria-hidden="true"></div>
                                        <!-- /.route-line__start -->
                                        <div class="route-line__stop" aria-hidden="true" style="left: 25%">
                                            <p class="route-line__stop-name">CGN</p>
                                        </div>
                                        <!-- /.route-line__stop -->
                                        <div class="route-line__stop" aria-hidden="true" style="left: 75%">
                                            <p class="route-line__stop-name">KTW</p>
                                        </div>
                                        <!-- /.route-line__stop -->
                                    </div>
                                    <!-- flight-card__route-line -->
                                </div>
                                <div class="flight-card__arrival">
                                    <time class="flight-card__time">11:55 PM</time>
                                    <h2 class="flight-card__city">Rome</h2>
                                    <time class="flight-card__day">Tuesday, Apr 22, 2020</time>
                                </div>
                                <!-- /.flight-card__arrival -->
                                <div class="flight-card__action">
                                    <p class="flight-card__price styled-price"><sup>$</sup>91<sub>USD</sub></p>
                                    <button class="flight-card__cta button button--orange">Select</button>
                                </div>
                                <!-- /.flight-card__action -->
                            </article>
                            <!-- /.flight-card -->
                        </section>

                    </section>

                    <aside class="user-card">
                        <figure class="user-card__avatar">
                            <img src="//picsum.photos/50/50" alt="">
                        </figure>
                        <div class="p user-card__heading">
                            Hello, <span class="user-card__name">Ford Prefect</span>
                        </div>
                    </aside>
                    <aside class="sidebar">
                        <section class="sidebar-section">
                            <button class="button button--purple sidebar__action">Get price alerts</button>
                        </section>
                        <!-- /.sidebar-section -->

                        <section class="sidebar-section">
                            <h2 class="sidebar-section__heading">Stops</h2>
                            <ul class="choice-list">
                                <li class="choice-list__item">
                                    <input id="checkbox-1" type="checkbox" class="checkbox" checked="checked">
                                    <label for="checkbox-1">Non-stop</label>
                                    <span class="choice-list__aside">$34</span>
                                </li>
                                <li class="choice-list__item">
                                    <input id="checkbox-2" type="checkbox" class="checkbox">
                                    <label for="checkbox-2">1 Stop</label>
                                    <span class="choice-list__aside">$70</span>
                                </li>
                                <li class="choice-list__item">
                                    <input id="checkbox-3" type="checkbox" class="checkbox">
                                    <label for="checkbox-3">2+ Stops</label>
                                    <span class="choice-list__aside">$98</span>
                                </li>
                            </ul>
                        </section>
                        <section class="sidebar-section">
                            <h2 class="sidebar-section__heading">Baggage</h2>
                            <ul class="choice-list">
                                <li class="choice-list__item">
                                    <input id="checkbox-4" type="checkbox" class="checkbox">
                                    <label for="checkbox-4">1 small bag</label>
                                    <span class="choice-list__aside">$34</span>
                                </li>
                                <li class="choice-list__item">
                                    <input id="checkbox-5" type="checkbox" class="checkbox" checked="checked">
                                    <label for="checkbox-5">2 cabin bags</label>
                                    <span class="choice-list__aside">$58</span>
                                </li>
                                <li class="choice-list__item">
                                    <input id="checkbox-6" type="checkbox" class="checkbox">
                                    <label for="checkbox-6">Checked-in bag</label>
                                    <span class="choice-list__aside">$112</span>
                                </li>
                            </ul>
                        </section>
                        <section class="sidebar-section">
                            <h2 class="sidebar-section__heading">Airports</h2>
                            <ul class="choice-list">
                                <li class="choice-list__item">
                                    <input id="checkbox-7" type="checkbox" class="checkbox">
                                    <label for="checkbox-7">CIA</label>
                                    <span class="choice-list__aside">Rome Ciampino</span>
                                </li>
                                <li class="choice-list__item">
                                    <input id="checkbox-8" type="checkbox" class="checkbox" checked="checked">
                                    <label for="checkbox-8">FCO</label>
                                    <span class="choice-list__aside">Rome Fiumicino</span>
                                </li>
                            </ul>
                        </section>
                    </aside>
                </section>
                <!-- /.dashboard -->
            </div>
            <!-- /.container -->
        </main>

    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>