<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>Your Flight Booking Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
    <link href="https://kit-pro.fontawesome.com/releases/latest/css/pro.min.css" media="all" rel="stylesheet">
    <style>
    :root {
        --color-off-white: hsl(240, 18%, 97%);
        --color-purple: hsl(239, 39%, 45%);
        --color-light-purple: hsl(240, 52%, 94%);
        --color-orange: hsl(13, 94%, 66%);
        --color-dark-orange: hsl(13, 94%, 46%);
        --font-weight-normal: 400;
        --font-weight-medium: 600;
        --font-weight-bold: 700;
        --ease-out-quart: cubic-bezier(0.25, 1, 0.5, 1);
    }

    rounded-corners(n=1.5rem) border-radius: n circular-image() border-radius: 100% overflow: hidden shadow-card() box-shadow: 0 0 0.1rem HSLA(var(--color-purple), 0.1) //--------------------
    // Setup
    //--------------------
    html box-sizing: border-box font-size: 10px // Easier rem values

    *,
    *::before,
    *::after box-sizing: inherit body font-family: poppins,
    sans-serif font-size: 1.6rem color: HSL(var(--color-purple)) background-color: HSL(var(--color-off-white)) text-rendering: optimizeLegibility;

    body input button -webkit-font-smoothing: antialiased -moz-osx-font-smoothing: grayscale img display: block max-width: 100% //--------------------
    // Layout
    //--------------------
    .container margin: 4rem auto width: 130rem padding: 0 4rem .dashboard display: grid grid-template-columns: repeat(12, 1fr) grid-template-rows: auto auto grid-gap: 3rem .booking-bar .flights grid-column: 1 / 10 .user-card .sidebar grid-column: 10 / -1 .sidebar align-self: start .user-card grid-row: 1 / 1 //--------------------
    // Inputs
    //--------------------
    $basic-input rounded-corners(0.6rem) padding: 1em 1em border: none color: HSL(var(--color-purple)) input[type="text"] input[type="search"] input[type="email"] input[type="phone"] @extend $basic-input .icon-input position: relative &__icon position: absolute left: 0.5em top: 50% color: HSL(var(--color-purple)) transform: translateY(-50%) input padding-left: 3em //--------------------
    // Checkbox
    //--------------------
    .checkbox position: absolute left: -9999px opacity: 0+label position: relative font-size: 1.5rem cursor: pointer // Checkbox box
    +label::before rounded-corners(0.8rem) content: ''
    display: inline-block margin-right: 1rem background-color: HSL(var(--color-light-purple)) width: 2.5rem height: 2.5rem vertical-align: text-top;
    transition: 0.5s background-color var(--ease-out-quart) // Checkbox Check
    +label::after display: inline-block position: absolute left: 0.6rem top: 0.7rem font-size: 1.2rem font-family: 'Font Awesome 5 Pro'
    font-weight: 600 color: white content: "\f00c"
    visibility: hidden // Hoover State
    &:hover+label::before background-color: HSL(var(--color-purple)) // Checked State
    &:checked+label::before background-color: HSL(var(--color-purple))+label::after visibility: visible //--------------------
    // Buttons
    //--------------------
    .button rounded-corners(0.8rem) padding: 0.75em 2em appearance: none background-color: HSL(var(--button-background-color, var(--color-orange))) color: HSL(var(--button-text-color, 0, 0%, 100%)) font-size: 1.8rem border: none cursor: pointer transition: background-color 0.7s var(--ease-out-quart),
    color 0.7s var(--ease-out-quart) &:hover background-color: HSL(var(--button-hover-background-color, var(--color-dark-orange))) color: HSL(var(--button-hover-text-color, 0, 0%, 100%)) .button--purple --button-background-color: var(--color-light-purple) --button-text-color: var(--color-purple) --button-hover-background-color: var(--color-purple) //--------------------
    // Choice List
    //--------------------
    .choice-list &__item display: flex justify-content: space-between align-items: center &:not(:last-child) margin-bottom: 1rem &__aside font-size: 1.4rem //--------------------
    // Styled Price
    //--------------------
    .styled-price font-size: 4rem font-weight: var(--font-weight-medium) sup vertical-align: top font-size: 1.5rem font-weight: var(--font-weight-normal) sub vertical-align: bottom font-size: 1.2rem font-weight: var(--font-weight-normal) //--------------------
    // Route Line
    //--------------------
    .route-line position: relative margin: 1rem 0 0 width: 100% height: 1px border: 0.1rem dashed HSL(var(--color-purple)) &__stop rounded-corners(100%) box-sizing: content-box width: 0.8rem height: 0.8rem position: absolute top: 50% background-color: HSL(var(--color-purple)) transform: translate3d(-50%, -50%, 0) &__stop-name margin-top: 1.5rem font-size: 1.4rem transform: translateX(-0.7rem) &__start left: 0 border: 0.6rem solid HSL(var(--color-purple)) background-color: white &__end right: 0 border: 0.6rem solid HSL(var(--color-light-purple)) transform: translate3d(50%, -50%, 0) //--------------------
    // Booking Bar
    //--------------------
    .booking-bar rounded-corners() display: flex justify-content: space-between align-items: center padding: 3rem background-color: HSL(var(--color-purple)) color: white &__inputs display: flex align-items: center .icon-input:not(:last-of-type) margin-right: 2rem &__heading margin-bottom: 0.8rem font-size: 1.8rem font-weight: var(--font-weight-medium) letter-spacing: 0.05rem &__sub-heading font-size: 1.4rem letter-spacing: 0.05rem //--------------------
    // User Card
    //--------------------
    .user-card rounded-corners() shadow-card() display: flex align-items: center padding: 2rem background-color: white &__avatar circular-image() margin-right: 2rem &__heading line-height: 1.25 font-size: 1.5rem &__name display: block font-weight: 600 //--------------------
    // Flights
    //--------------------
    .flights &__total margin-bottom: 1rem font-weight: var(--font-weight-medium) span font-size: 1.3rem //--------------------
    // Top Flights
    //--------------------
    .top-flights display: flex justify-content: space-between margin-bottom: 3rem .top-flight-card:not(:last-child) margin-right: 2rem .top-flight-card rounded-corners() shadow-card() display: flex padding: 2rem background-color: white cursor: pointer transition: 0.6s var(--ease-out-quart) &__price margin-right: 1.5rem &__heading margin-bottom: 0.4rem font-weight: var(--font-weight-medium) &__sub-heading font-size: 1rem .top-flight-card.is-active .top-flight-card:hover background-color: HSL(var(--color-purple)) color: white //--------------------
    // Flights List
    //--------------------
    .flights-list &__item:not(:last-child) margin-bottom: 2.5rem //--------------------
    // Flight Card
    //--------------------
    .flight-card rounded-corners() shadow-card() display: flex justify-content: space-between align-items: center padding: 3rem background-color: white &__airline circular-image() flex: 0 1 5rem border: 0.2rem solid white &+.flight-card__airline position: relative top: -1.5rem &__departure margin-left: 2rem &__arrival margin-right: 3rem text-align: right &__route display: flex flex-direction: column flex: 1 0 auto justify-content: center align-items: center padding: 0 4rem &__duration &__type font-size: 1.4rem &__type margin-top: 1rem &__action text-align: center &__time display: inline-block margin-bottom: 0.8rem font-size: 2rem font-weight: var(--font-weight-medium) &__city margin-bottom: 0.4rem font-size: 1.8rem &__day font-size: 1.4rem &__price margin-bottom: 1rem &__cta min-width: 16rem //--------------------
    // Sibebar
    //--------------------
    .sidebar shadow-card() rounded-corners() margin-top: 2.6rem padding: 3rem 2rem background-color: white &__action width: 100% .sidebar-section &:not(:last-child) margin-bottom: 4rem &__heading margin-bottom: 1.5rem font-size: 2.2rem font-weight: var(--font-weight-medium)
    </style>
</head>

<body>
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
                                <!-- /.top-flight-card__info -->
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


</body>

</html>