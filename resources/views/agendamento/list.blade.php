@extends('layouts.template')

@section('title', config('app.name')." - Exibir Agendamento")
@section('pagina', 'Exibir Agendamento')
@section('pagina2', 'Exibir Agendamento')

@section('content')
<div class="container mt-3">
    <div id="corpo1">
        <h2>Tabela de Agendamento</h2>
        <p>
            Digite algo no campo de entrada abaixo para pesquisar na tabela:
        </p>
        <input class="form-control" id="myInput" type="text" placeholder="Procurar..">
        <br>

        <div class="form-group col-md-12" style="text-align: center;">
            <button onclick="calendario();" class="btn btn-info">Exibir como calendario</button>
            <a class="btn btn-success" style="align: center;" href="{{route('agendamento.create')}}">Novo agendamento</a>
        </div>
    </div>
    <div id="corpocalendar" style="display:none; text-align: center;">
        <button onclick="ocultar();" class="btn btn-danger" style="margin: 10px;">Exibir como tabela</button>
        <div id="calendar"></div>

    </div>

    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/lang/pt.min.js" ></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment-with-langs.min.js"></script>
    <style>
        *,
        *:before,
        *:after {
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            /* overflow: hidden; */
            font-family: 'HelveticaNeue-UltraLight', 'Helvetica Neue UltraLight', 'Helvetica Neue', Arial, Helvetica, sans-serif;
            font-weight: 100;
            /* color: rgba(255, 255, 255, 1); */
            margin: 0;
            padding: 0;
            /* background: #4A4A4A; */
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

        }

        #calendar {
            color: rgba(255, 255, 255, 1);
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            width: 420px;
            margin: 0 auto;
            height: 570px;
            overflow: hidden;
        }

        .header {
            height: 50px;
            width: 420px;
            background: rgba(66, 66, 66, 1);
            text-align: center;
            position: relative;
            z-index: 100;
        }

        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 20px;
            line-height: 50px;
            font-weight: 100;
            letter-spacing: 1px;
        }

        .left,
        .right {
            position: absolute;
            width: 0px;
            height: 0px;
            border-style: solid;
            top: 50%;
            margin-top: -7.5px;
            cursor: pointer;
        }

        .left {
            border-width: 7.5px 10px 7.5px 0;
            border-color: transparent rgba(160, 159, 160, 1) transparent transparent;
            left: 20px;
        }

        .right {
            border-width: 7.5px 0 7.5px 10px;
            border-color: transparent transparent transparent rgba(160, 159, 160, 1);
            right: 20px;
        }

        .month {
            /*overflow: hidden;*/
            opacity: 0;
        }

        .month.new {
            -webkit-animation: fadeIn 1s ease-out;
            opacity: 1;
        }

        .month.in.next {
            -webkit-animation: moveFromTopFadeMonth .4s ease-out;
            -moz-animation: moveFromTopFadeMonth .4s ease-out;
            animation: moveFromTopFadeMonth .4s ease-out;
            opacity: 1;
        }

        .month.out.next {
            -webkit-animation: moveToTopFadeMonth .4s ease-in;
            -moz-animation: moveToTopFadeMonth .4s ease-in;
            animation: moveToTopFadeMonth .4s ease-in;
            opacity: 1;
        }

        .month.in.prev {
            -webkit-animation: moveFromBottomFadeMonth .4s ease-out;
            -moz-animation: moveFromBottomFadeMonth .4s ease-out;
            animation: moveFromBottomFadeMonth .4s ease-out;
            opacity: 1;
        }

        .month.out.prev {
            -webkit-animation: moveToBottomFadeMonth .4s ease-in;
            -moz-animation: moveToBottomFadeMonth .4s ease-in;
            animation: moveToBottomFadeMonth .4s ease-in;
            opacity: 1;
        }

        .week {
            background: #4A4A4A;
        }

        .day {
            display: inline-block;
            width: 60px;
            padding: 10px;
            text-align: center;
            vertical-align: top;
            cursor: pointer;
            background: #4A4A4A;
            position: relative;
            z-index: 100;
        }

        .day.other {
            color: rgba(255, 255, 255, .3);
        }

        .day.today {
            color: rgba(156, 202, 235, 1);
        }

        .day-name {
            font-size: 9px;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, .5);
            letter-spacing: .7px;
        }

        .day-number {
            font-size: 24px;
            letter-spacing: 1.5px;
        }


        .day .day-events {
            list-style: none;
            margin-top: 3px;
            text-align: center;
            height: 12px;
            line-height: 6px;
            overflow: hidden;
        }

        .day .day-events span {
            vertical-align: top;
            display: inline-block;
            padding: 0;
            margin: 0;
            width: 5px;
            height: 5px;
            line-height: 5px;
            margin: 0 1px;
        }

        .blue {
            background: rgba(156, 202, 235, 1);
        }

        .orange {
            background: rgba(247, 167, 0, 1);
        }

        .green {
            background: rgba(153, 198, 109, 1);
        }

        .yellow {
            background: rgba(249, 233, 0, 1);
        }

        .details {
            position: relative;
            width: 420px;
            height: 75px;
            background: rgba(164, 164, 164, 1);
            margin-top: 5px;
            border-radius: 4px;
        }

        .details.in {
            -webkit-animation: moveFromTopFade .5s ease both;
            -moz-animation: moveFromTopFade .5s ease both;
            animation: moveFromTopFade .5s ease both;
        }

        .details.out {
            -webkit-animation: moveToTopFade .5s ease both;
            -moz-animation: moveToTopFade .5s ease both;
            animation: moveToTopFade .5s ease both;
        }

        .arrow {
            position: absolute;
            top: -5px;
            left: 50%;
            margin-left: -2px;
            width: 0px;
            height: 0px;
            border-style: solid;
            border-width: 0 5px 5px 5px;
            border-color: transparent transparent rgba(164, 164, 164, 1) transparent;
            transition: all 0.7s ease;
        }

        .events {
            height: 75px;
            padding: 7px 0;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .events.in {
            -webkit-animation: fadeIn .3s ease both;
            -moz-animation: fadeIn .3s ease both;
            animation: fadeIn .3s ease both;
        }

        .events.in {
            -webkit-animation-delay: .3s;
            -moz-animation-delay: .3s;
            animation-delay: .3s;
        }

        .details.out .events {
            -webkit-animation: fadeOutShrink .4s ease both;
            -moz-animation: fadeOutShink .4s ease both;
            animation: fadeOutShink .4s ease both;
        }

        .events.out {
            -webkit-animation: fadeOut .3s ease both;
            -moz-animation: fadeOut .3s ease both;
            animation: fadeOut .3s ease both;
        }

        .event {
            font-size: 16px;
            line-height: 22px;
            letter-spacing: .5px;
            padding: 2px 16px;
            vertical-align: top;
        }

        .event.empty {
            color: #eee;
        }

        .event-category {
            height: 10px;
            width: 10px;
            display: inline-block;
            margin: 6px 0 0;
            vertical-align: top;
        }

        .event span {
            display: inline-block;
            padding: 0 0 0 7px;
        }

        .legend {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 30px;
            background: rgba(60, 60, 60, 1);
            line-height: 30px;

        }

        .entry {
            position: relative;
            padding: 0 0 0 25px;
            font-size: 13px;
            display: inline-block;
            line-height: 30px;
            background: transparent;
        }

        .entry:after {
            position: absolute;
            content: '';
            height: 5px;
            width: 5px;
            top: 12px;
            left: 14px;
        }

        .entry.blue:after {
            background: rgba(156, 202, 235, 1);
        }

        .entry.orange:after {
            background: rgba(247, 167, 0, 1);
        }

        .entry.green:after {
            background: rgba(153, 198, 109, 1);
        }

        .entry.yellow:after {
            background: rgba(249, 233, 0, 1);
        }

        /* Animations are cool!  */
        @-webkit-keyframes moveFromTopFade {
            from {
                opacity: .3;
                height: 0px;
                margin-top: 0px;
                -webkit-transform: translateY(-100%);
            }
        }

        @-moz-keyframes moveFromTopFade {
            from {
                height: 0px;
                margin-top: 0px;
                -moz-transform: translateY(-100%);
            }
        }

        @keyframes moveFromTopFade {
            from {
                height: 0px;
                margin-top: 0px;
                transform: translateY(-100%);
            }
        }

        @-webkit-keyframes moveToTopFade {
            to {
                opacity: .3;
                height: 0px;
                margin-top: 0px;
                opacity: 0.3;
                -webkit-transform: translateY(-100%);
            }
        }

        @-moz-keyframes moveToTopFade {
            to {
                height: 0px;
                -moz-transform: translateY(-100%);
            }
        }

        @keyframes moveToTopFade {
            to {
                height: 0px;
                transform: translateY(-100%);
            }
        }

        @-webkit-keyframes moveToTopFadeMonth {
            to {
                opacity: 0;
                -webkit-transform: translateY(-30%) scale(.95);
            }
        }

        @-moz-keyframes moveToTopFadeMonth {
            to {
                opacity: 0;
                -moz-transform: translateY(-30%);
            }
        }

        @keyframes moveToTopFadeMonth {
            to {
                opacity: 0;
                -moz-transform: translateY(-30%);
            }
        }

        @-webkit-keyframes moveFromTopFadeMonth {
            from {
                opacity: 0;
                -webkit-transform: translateY(30%) scale(.95);
            }
        }

        @-moz-keyframes moveFromTopFadeMonth {
            from {
                opacity: 0;
                -moz-transform: translateY(30%);
            }
        }

        @keyframes moveFromTopFadeMonth {
            from {
                opacity: 0;
                -moz-transform: translateY(30%);
            }
        }

        @-webkit-keyframes moveToBottomFadeMonth {
            to {
                opacity: 0;
                -webkit-transform: translateY(30%) scale(.95);
            }
        }

        @-moz-keyframes moveToBottomFadeMonth {
            to {
                opacity: 0;
                -webkit-transform: translateY(30%);
            }
        }

        @keyframes moveToBottomFadeMonth {
            to {
                opacity: 0;
                -webkit-transform: translateY(30%);
            }
        }

        @-webkit-keyframes moveFromBottomFadeMonth {
            from {
                opacity: 0;
                -webkit-transform: translateY(-30%) scale(.95);
            }
        }

        @-moz-keyframes moveFromBottomFadeMonth {
            from {
                opacity: 0;
                -webkit-transform: translateY(-30%);
            }
        }

        @keyframes moveFromBottomFadeMonth {
            from {
                opacity: 0;
                -webkit-transform: translateY(-30%);
            }
        }

        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }
        }

        @-moz-keyframes fadeIn {
            from {
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
        }

        @-webkit-keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        @-moz-keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
        }

        @-webkit-keyframes fadeOutShink {
            to {
                opacity: 0;
                padding: 0px;
                height: 0px;
            }
        }

        @-moz-keyframes fadeOutShink {
            to {
                opacity: 0;
                padding: 0px;
                height: 0px;
            }
        }

        @keyframes fadeOutShink {
            to {
                opacity: 0;
                padding: 0px;
                height: 0px;
            }
        }
    </style>
    <script>
        ! function() {

            var today = moment();
            moment.lang("pt-BR");
            // var today = moment();

            function Calendar(selector, events) {
                this.el = document.querySelector(selector);
                this.events = events;
                this.current = moment().date(1);
                this.draw();
                var current = document.querySelector('.today');
                if (current) {
                    var self = this;
                    window.setTimeout(function() {
                        self.openDay(current);
                    }, 500);
                }
            }

            Calendar.prototype.draw = function() {
                //Create Header
                this.drawHeader();

                //Draw Month
                this.drawMonth();

                this.drawLegend();
            }

            Calendar.prototype.drawHeader = function() {
                var self = this;
                if (!this.header) {
                    //Create the header elements
                    this.header = createElement('div', 'header');
                    this.header.className = 'header';

                    this.title = createElement('h1');

                    var right = createElement('div', 'right');
                    right.addEventListener('click', function() {
                        self.nextMonth();
                    });

                    var left = createElement('div', 'left');
                    left.addEventListener('click', function() {
                        self.prevMonth();
                    });

                    //Append the Elements
                    this.header.appendChild(this.title);
                    this.header.appendChild(right);
                    this.header.appendChild(left);
                    this.el.appendChild(this.header);
                }

                this.title.innerHTML = this.current.format('MMMM YYYY');
            }

            Calendar.prototype.drawMonth = function() {
                var self = this;

                this.events.forEach(function(ev) {

                    //aqui fica a data
                    // ev.date = self.current.clone().date(Math.random() * (28 - 1) + 1);
                    ev.date = moment(ev.date);
                    // console.log(ev.date);
                });


                if (this.month) {
                    this.oldMonth = this.month;
                    this.oldMonth.className = 'month out ' + (self.next ? 'next' : 'prev');
                    this.oldMonth.addEventListener('webkitAnimationEnd', function() {
                        self.oldMonth.parentNode.removeChild(self.oldMonth);
                        self.month = createElement('div', 'month');
                        self.backFill();
                        self.currentMonth();
                        self.fowardFill();
                        self.el.appendChild(self.month);
                        window.setTimeout(function() {
                            self.month.className = 'month in ' + (self.next ? 'next' : 'prev');
                        }, 16);
                    });
                } else {
                    this.month = createElement('div', 'month');
                    this.el.appendChild(this.month);
                    this.backFill();
                    this.currentMonth();
                    this.fowardFill();
                    this.month.className = 'month new';
                }
            }

            Calendar.prototype.backFill = function() {
                var clone = this.current.clone();
                var dayOfWeek = clone.day();

                if (!dayOfWeek) {
                    return;
                }

                clone.subtract('days', dayOfWeek + 1);

                for (var i = dayOfWeek; i > 0; i--) {
                    this.drawDay(clone.add('days', 1));
                }
            }

            Calendar.prototype.fowardFill = function() {
                var clone = this.current.clone().add('months', 1).subtract('days', 1);
                var dayOfWeek = clone.day();

                if (dayOfWeek === 6) {
                    return;
                }

                for (var i = dayOfWeek; i < 6; i++) {
                    this.drawDay(clone.add('days', 1));
                }
            }

            Calendar.prototype.currentMonth = function() {
                var clone = this.current.clone();

                while (clone.month() === this.current.month()) {
                    this.drawDay(clone);
                    clone.add('days', 1);
                }
            }

            Calendar.prototype.getWeek = function(day) {
                if (!this.week || day.day() === 0) {
                    this.week = createElement('div', 'week');
                    this.month.appendChild(this.week);
                }
            }

            Calendar.prototype.drawDay = function(day) {
                var self = this;
                this.getWeek(day);

                //Outer Day
                var outer = createElement('div', this.getDayClass(day));
                outer.addEventListener('click', function() {
                    self.openDay(this);
                });

                //Day Name
                var name = createElement('div', 'day-name', day.format('ddd'));

                //Day Number
                var number = createElement('div', 'day-number', day.format('DD'));


                //Events
                var events = createElement('div', 'day-events');
                this.drawEvents(day, events);

                outer.appendChild(name);
                outer.appendChild(number);
                outer.appendChild(events);
                this.week.appendChild(outer);
            }

            Calendar.prototype.drawEvents = function(day, element) {
                if (day.month() === this.current.month()) {
                    var todaysEvents = this.events.reduce(function(memo, ev) {
                        if (ev.date.isSame(day, 'day')) {
                            memo.push(ev);
                        }
                        return memo;
                    }, []);

                    todaysEvents.forEach(function(ev) {
                        var evSpan = createElement('span', ev.color);
                        element.appendChild(evSpan);
                    });
                }
            }

            Calendar.prototype.getDayClass = function(day) {
                classes = ['day'];
                if (day.month() !== this.current.month()) {
                    classes.push('other');
                } else if (today.isSame(day, 'day')) {
                    classes.push('today');
                }
                return classes.join(' ');
            }

            Calendar.prototype.openDay = function(el) {
                var details, arrow;
                var dayNumber = +el.querySelectorAll('.day-number')[0].innerText || +el.querySelectorAll('.day-number')[0].textContent;
                var day = this.current.clone().date(dayNumber);

                var currentOpened = document.querySelector('.details');

                //Check to see if there is an open detais box on the current row
                if (currentOpened && currentOpened.parentNode === el.parentNode) {
                    details = currentOpened;
                    arrow = document.querySelector('.arrow');
                } else {
                    //Close the open events on differnt week row
                    //currentOpened && currentOpened.parentNode.removeChild(currentOpened);
                    if (currentOpened) {
                        currentOpened.addEventListener('webkitAnimationEnd', function() {
                            currentOpened.parentNode.removeChild(currentOpened);
                        });
                        currentOpened.addEventListener('oanimationend', function() {
                            currentOpened.parentNode.removeChild(currentOpened);
                        });
                        currentOpened.addEventListener('msAnimationEnd', function() {
                            currentOpened.parentNode.removeChild(currentOpened);
                        });
                        currentOpened.addEventListener('animationend', function() {
                            currentOpened.parentNode.removeChild(currentOpened);
                        });
                        currentOpened.className = 'details out';
                    }

                    //Create the Details Container
                    details = createElement('div', 'details in');

                    //Create the arrow
                    var arrow = createElement('div', 'arrow');

                    //Create the event wrapper

                    details.appendChild(arrow);
                    el.parentNode.appendChild(details);
                }

                var todaysEvents = this.events.reduce(function(memo, ev) {
                    if (ev.date.isSame(day, 'day')) {
                        memo.push(ev);
                    }
                    return memo;
                }, []);

                this.renderEvents(todaysEvents, details);

                arrow.style.left = el.offsetLeft - el.parentNode.offsetLeft + 27 + 'px';
            }

            Calendar.prototype.renderEvents = function(events, ele) {
                //Remove any events in the current details element
                var currentWrapper = ele.querySelector('.events');
                var wrapper = createElement('div', 'events in' + (currentWrapper ? ' new' : ''));

                events.forEach(function(ev) {
                    var div = createElement('div', 'event');
                    var square = createElement('div', 'event-category ' + ev.color);
                    var span = createElement('span', '', );
                    var a = createElement('a', '', ev.eventName);
                    a.href = ev.link;

                    div.appendChild(square);
                    div.appendChild(span);
                    span.appendChild(a);

                    wrapper.appendChild(div);
                });

                if (!events.length) {
                    var div = createElement('div', 'event empty');
                    var span = createElement('span', '', 'Sem agendamento');

                    div.appendChild(span);
                    wrapper.appendChild(div);
                }

                if (currentWrapper) {
                    currentWrapper.className = 'events out';
                    currentWrapper.addEventListener('webkitAnimationEnd', function() {
                        currentWrapper.parentNode.removeChild(currentWrapper);
                        ele.appendChild(wrapper);
                    });
                    currentWrapper.addEventListener('oanimationend', function() {
                        currentWrapper.parentNode.removeChild(currentWrapper);
                        ele.appendChild(wrapper);
                    });
                    currentWrapper.addEventListener('msAnimationEnd', function() {
                        currentWrapper.parentNode.removeChild(currentWrapper);
                        ele.appendChild(wrapper);
                    });
                    currentWrapper.addEventListener('animationend', function() {
                        currentWrapper.parentNode.removeChild(currentWrapper);
                        ele.appendChild(wrapper);
                    });
                } else {
                    ele.appendChild(wrapper);
                }
            }

            Calendar.prototype.drawLegend = function() {
                var legend = createElement('div', 'legend');
                var calendars = this.events.map(function(e) {
                    return e.calendar + '|' + e.color;
                }).reduce(function(memo, e) {
                    if (memo.indexOf(e) === -1) {
                        memo.push(e);
                    }
                    return memo;
                }, []).forEach(function(e) {
                    var parts = e.split('|');
                    var entry = createElement('span', 'entry ' + parts[1], parts[0]);
                    legend.appendChild(entry);
                });
                this.el.appendChild(legend);
            }

            Calendar.prototype.nextMonth = function() {
                this.current.add('months', 1);
                this.next = true;
                this.draw();
            }

            Calendar.prototype.prevMonth = function() {
                this.current.subtract('months', 1);
                this.next = false;
                this.draw();
            }

            window.Calendar = Calendar;

            function createElement(tagName, className, innerText) {
                var ele = document.createElement(tagName);
                if (className) {
                    ele.className = className;
                }
                if (innerText) {
                    ele.innderText = ele.textContent = innerText;
                }
                return ele;
            }
        }();

        ! function() {
            var choices = ["orange", "blue", "yellow", "green"];
            var data = [

                @foreach($agendamentos as $agendamento)


                {

                    eventName: "{{$agendamento->usuario->nome}} às {{$agendamento->hora}}",
                    calendar: 'Work',
                    color: choices[Math.floor((Math.random() * choices.length))],
                    date: "{{$agendamento->data}}",
                    link: "{{route('agendamento.show', $agendamento->id )}}",

                },
                @endforeach

            ];



            function addDate(ev) {

            }

            var calendar = new Calendar('#calendar', data);

        }();
    </script>
    <script>
        function calendario() {
            event.preventDefault();
            document.getElementById('corpocalendar').style.display = 'block';
            document.getElementById('corpo1').style.display = 'none';
            document.getElementById('table').style.display = 'none';

        }

        function ocultar() {
            event.preventDefault();
            document.getElementById('corpocalendar').style.display = 'none';
            document.getElementById('corpo1').style.display = 'block';
            document.getElementById('table').style.display = 'block';

        }
    </script>

    <table id="table" class="table table-bordered table-hover" style="text-align: center;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>RG</th>
                <th>Contato</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Descrição</th>
                <th>Registro</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="myTable">
            @foreach($agendamentos as $agendamento)
            <tr>
                <td><a href="{{route('usuario.show', $agendamento->usuario->id )}}">{{$agendamento->usuario->nome}}</a></td>
                <td>{{$agendamento->usuario->cpf}}</td>
                <td>{{$agendamento->usuario->rg}}</td>

                <td>{{$agendamento->usuario->contato}}</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i:s')}}</td>
                <td>
                    {{$agendamento->descricao}}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($agendamento->created_at)->format('d/m/Y - H:i:s')}} por {{$agendamento->user->name}}
                </td>
                <td> <a title="Detalhes do agendamento" style="display: inline-block;" href="{{route('agendamento.show', $agendamento->id)}}"><i class="bi bi-eye" style="font-size: 1.4rem; color: blue; padding: 0.3rem;"></i></a>
                    <a title="Editar agendamento" style="display: inline-block;" href="{{route('agendamento.edit', $agendamento->id)}}"><i class="bi-pencil" style="font-size: 1.4rem; color: green;"></i></a>

                    <button title="Exluir agendamento" type="button" data-toggle="modal" data-target="#exampleModal" data-whatever="{{route('agendamento.destroy', $agendamento->id)}}"><i class="bi-trash" style="font-size: 1.4rem; color: red;"></i></button>
                    <!-- <a style="display: inline-block;" title="Alterar a situação" href=""><i class="bi bi-list-ol" style="font-size: 1.4rem; color: black;"></i></a> -->
                </td>
            </tr>

            @endforeach



        </tbody>
    </table>

</div>
<style>
    table button {
        background-color: Transparent;
        background-repeat: no-repeat;
        border: none;
        cursor: pointer;
        overflow: hidden;
    }
</style>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atenção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <label for="recipient-name" class="col-form-label"><b>Tem certeza que deseja deletar este agendamento? </b><br>Esta ação não poderá ser desfeita!</label>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <form name="formdel" action="" id="formmodal" method="post" style="display: inline-block;">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-primary" type="button" onclick="enviar();" id="deletarbtn">Excluir agendamento</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    $('#exampleModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)

        // var ac = "route('agendamento.destroy', '" + recipient + "')"

        // $('#formdel').attr('action', recipient)
        document.formdel.action = recipient;
        // $('#formmodal').attr('action', ac + '/' + recipient)
    })

    function enviar() {

        document.formdel.submit();
    }
</script>

@stop