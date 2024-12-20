<article class="kontext">
	<div class="layer one show">
		<h2><img class="banner_img" src="{{ asset('images/WhatsApp Image 2024-12-14 at 6.50.52 PM.jpeg') }}" alt=""></h2>
	</div>
	<div class="layer two">
		<h2><img class="banner_img" src="{{ asset('images/22.jpeg') }}" alt=""></h2>
	</div>
	{{--  <div class="layer three">
		<h2><img class="banner_img" src="{{ asset('images/WhatsApp Image 2024-12-14 at 6.50.52 PM.jpeg') }}" alt=""></h2>
	</div>  --}}
</article>

<ul class="bullets"></ul>
<style>
    .banner_img {
        width: 800px;
    }

    .kontext {
        padding: 200px 0 ;
        width: 100%;
        height: 100%;
    }
    .bullets {
        transform: translateY(100px)
        width: 100%;
        bottom: 20px;
        padding: 0;
        margin: 0;
        text-align: center;
    }



    .kontext .layer {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        visibility: hidden;
    }

    .kontext .layer.show {
        visibility: visible;
    }

    .kontext.capable {
        -webkit-perspective: 1000px;
           -moz-perspective: 1000px;
                perspective: 1000px;

        -webkit-transform-style: preserve-3d;
           -moz-transform-style: preserve-3d;
                transform-style: preserve-3d;
    }

    .kontext.capable .layer {
        -webkit-transform: translateZ( -100px );
           -moz-transform: translateZ( -100px );
                transform: translateZ( -100px );
    }

    .kontext.capable .layer.show {
        -webkit-transform: translateZ( 0px );
           -moz-transform: translateZ( 0px );
                transform: translateZ( 0px );
    }

    .kontext.capable.animate .layer.show.right {
        -webkit-animation: show-right 1s forwards ease;
           -moz-animation: show-right 1s forwards ease;
                animation: show-right 1s forwards ease;
    }

    .kontext.capable.animate .layer.hide.right {
        -webkit-animation: hide-right 1s forwards ease;
           -moz-animation: hide-right 1s forwards ease;
                animation: hide-right 1s forwards ease;
    }

    .kontext.capable.animate .layer.show.left {
        -webkit-animation: show-left 1s forwards ease;
           -moz-animation: show-left 1s forwards ease;
                animation: show-left 1s forwards ease;
    }

    .kontext.capable.animate .layer.hide.left {
        -webkit-animation: hide-left 1s forwards ease;
           -moz-animation: hide-left 1s forwards ease;
                animation: hide-left 1s forwards ease;
    }


    /* CSS animation keyframes */

    @-webkit-keyframes show-right {
        0%   { -webkit-transform: translateZ( -200px ); }
        40%  { -webkit-transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { -webkit-transform: translateZ( 0px ); }
    }

    @-webkit-keyframes hide-right {
        0%   { -webkit-transform: translateZ( 0px ); visibility: visible; }
        40%  { -webkit-transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { -webkit-transform: translateZ( -200px ); visibility: hidden; }
    }

    @-moz-keyframes show-right {
        0%   { -moz-transform: translateZ( -200px ); }
        40%  { -moz-transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { -moz-transform: translateZ( 0px ); }
    }

    @-moz-keyframes hide-right {
        0%   { -moz-transform: translateZ( 0px ); visibility: visible; }
        40%  { -moz-transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { -moz-transform: translateZ( -200px ); visibility: hidden; }
    }

    @keyframes show-right {
        0%   { transform: translateZ( -200px ); }
        40%  { transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { transform: translateZ( 0px ); }
    }

    @keyframes hide-right {
        0%   { transform: translateZ( 0px ); visibility: visible; }
        40%  { transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { transform: translateZ( -200px ); visibility: hidden; }
    }


    @-webkit-keyframes show-left {
        0%   { -webkit-transform: translateZ( -200px ); }
        40%  { -webkit-transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { -webkit-transform: translateZ( 0px ); }
    }

    @-webkit-keyframes hide-left {
        0%   { -webkit-transform: translateZ( 0px ); visibility: visible; }
        40%  { -webkit-transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { -webkit-transform: translateZ( -200px ); visibility: hidden; }
    }

    @-moz-keyframes show-left {
        0%   { -moz-transform: translateZ( -200px ); }
        40%  { -moz-transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { -moz-transform: translateZ( 0px ); }
    }

    @-moz-keyframes hide-left {
        0%   { -moz-transform: translateZ( 0px ); visibility: visible; }
        40%  { -moz-transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { -moz-transform: translateZ( -200px ); visibility: hidden; }
    }

    @keyframes show-left {
        0%   { transform: translateZ( -200px ); }
        40%  { transform: translate( -40%, 0 ) scale( 0.8 ) rotateY( 20deg ); }
        100% { transform: translateZ( 0px ); }
    }

    @keyframes hide-left {
        0%   { transform: translateZ( 0px ); visibility: visible; }
        40%  { transform: translate( 40%, 0 ) scale( 0.8 ) rotateY( -20deg ); }
        100% { transform: translateZ( -200px ); visibility: hidden; }
    }


    /* Dimmer */

    .kontext .layer .dimmer {
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        visibility: hidden;
        background: transparent;
    }

        .kontext.capable.animate .layer .dimmer {
            -webkit-transition: background 1s ease;
               -moz-transition: background 1s ease;
                    transition: background 1s ease;
        }

        .kontext.capable.animate .layer.hide .dimmer {
            visibility: visible;
            background: rgba( 0, 0, 0, 0.7 );
        }



    .layer {
        text-align: center;
        text-shadow: 1px 1px 0px rgba( 0, 0, 0, 0.1 );
    }

    .layer h2 {
        position: relative;
        top: 20%;
        margin: 0;
        font-size: 6.25em;
    }

    .layer p {
        position: relative;
        top: 20%;
        margin: 0;
    }




        .bullets li {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin: 0 3px;
            margin: 100px 0 0 0;
            background: rgba( 255, 255, 255, 0.5 );
            box-shadow: 0px 0px 4px rgba( 0, 0, 0, 0.2 );
            cursor: pointer;

            -webkit-tap-highlight-color: rgba( 0, 0, 0, 0 );
        }

            .bullets li:hover {
                background: rgba( 255, 255, 255, 0.8 );
            }

            .bullets li.active {
                cursor: default;
                background: #fff;
            }

    @media screen and (max-width: 400px) {

        .bullets li {
            margin: 0 6px;
        }
    }
    @media screen and (max-width: 1024px) {
        .bullets {
            width: 100%;
            bottom: 20px;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .banner_img {
            width: 250px;
        }

    .kontext {
        padding: 100px 0 ;
        width: 100%;
        height: 100%;
    }
    }

</style>
<script>
    window.kontext = function( container ) {

        // Dispatched when the current layer changes
        var changed = new kontext.Signal();

        // All layers in this instance of kontext
        var layers = Array.prototype.slice.call( container.querySelectorAll( '.layer' ) );

        // Flag if the browser is capable of handling our fancy transition
        var capable =	'WebkitPerspective' in document.body.style ||
                        'MozPerspective' in document.body.style ||
                        'msPerspective' in document.body.style ||
                        'OPerspective' in document.body.style ||
                        'perspective' in document.body.style;

        if( capable ) {
            container.classList.add( 'capable' );
        }

        // Create dimmer elements to fade out preceding slides
        layers.forEach( function( el, i ) {
            if( !el.querySelector( '.dimmer' ) ) el.innerHTML += '<div class="dimmer"></div>';
        } );

        /**
         * Transitions to and shows the target layer.
         *
         * @param target index of layer or layer DOM element
         */
        function show( target, direction ) {

            // Make sure our listing of available layers is up to date
            layers = Array.prototype.slice.call( container.querySelectorAll( '.layer' ) );

            // Flag to CSS that we're ready to animate transitions
            container.classList.add( 'animate' );

            // Flag which direction
            direction = direction || ( target > getIndex() ? 'right' : 'left' );

            // Accept multiple types of targets
            if( typeof target === 'string' ) target = parseInt( target );
            if( typeof target !== 'number' ) target = getIndex( target );

            // Enforce index bounds
            target = Math.max( Math.min( target, layers.length ), 0 );

            // Only navigate if were able to locate the target
            if( layers[ target ] && !layers[ target ].classList.contains( 'show' ) ) {

                layers.forEach( function( el, i ) {
                    el.classList.remove( 'left', 'right' );
                    el.classList.add( direction );
                    if( el.classList.contains( 'show' ) ) {
                        el.classList.remove( 'show' );
                        el.classList.add( 'hide' );
                    }
                    else {
                        el.classList.remove( 'hide' );
                    }
                } );

                layers[ target ].classList.add( 'show' );

                changed.dispatch( layers[target], target );

            }

        }

        /**
         * Shows the previous layer.
         */
        function prev() {

            var index = getIndex() - 1;
            show( index >= 0 ? index : layers.length + index, 'left' );

        }

        /**
         * Shows the next layer.
         */
        function next() {

            show( ( getIndex() + 1 ) % layers.length, 'right' );

        }

        /**
         * Retrieves the index of the current slide.
         *
         * @param of [optional] layer DOM element which index is
         * to be returned
         */
        function getIndex( of ) {

            var index = 0;

            layers.forEach( function( layer, i ) {
                if( ( of && of == layer ) || ( !of && layer.classList.contains( 'show' ) ) ) {
                    index = i;
                    return;
                }
            } );

            return index;

        }

        /**
         * Retrieves the total number of layers.
         */
        function getTotal() {

            return layers.length;

        }

        // API
        return {

            show: show,
            prev: prev,
            next: next,

            getIndex: getIndex,
            getTotal: getTotal,

            changed: changed

        };

    };

    /**
     * Minimal utility for dispatching signals (events).
     */
    kontext.Signal = function() {
        this.listeners = [];
    }

    kontext.Signal.prototype.add = function( callback ) {
        this.listeners.push( callback );
    }

    kontext.Signal.prototype.remove = function( callback ) {
        var i = this.listeners.indexOf( callback );

        if( i >= 0 ) this.listeners.splice( i, 1 );
    }

    kontext.Signal.prototype.dispatch = function() {
        var args = Array.prototype.slice.call( arguments );
        this.listeners.forEach( function( f, i ) {
            f.apply( null, args );
        } );
    }






    // Create a new instance of kontext
    var k = kontext( document.querySelector( '.kontext' ) );


    // Demo page JS

    var bulletsContainer = document.body.querySelector( '.bullets' );

    // Create one bullet per layer
    for( var i = 0, len = k.getTotal(); i < len; i++ ) {
        var bullet = document.createElement( 'li' );
        bullet.className = i === 0 ? 'active' : '';
        bullet.setAttribute( 'index', i );
        bullet.onclick = function( event ) { k.show( event.target.getAttribute( 'index' ) ) };
        bullet.ontouchstart = function( event ) { k.show( event.target.getAttribute( 'index' ) ) };
        bulletsContainer.appendChild( bullet );
    }

    // Update the bullets when the layer changes
    k.changed.add( function( layer, index ) {
        var bullets = document.body.querySelectorAll( '.bullets li' );
        for( var i = 0, len = bullets.length; i < len; i++ ) {
            bullets[i].className = i === index ? 'active' : '';
        }
    } );

    document.addEventListener( 'keyup', function( event ) {
        if( event.keyCode === 37 ) k.prev();
        if( event.keyCode === 39 ) k.next();
    }, false );
</script>
