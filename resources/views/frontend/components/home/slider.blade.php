<section class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul id="slider-list">
            
        </ul>
    </div>
    <div id="splash-image" class="splash-image">
        <img src="/path/to/splash-image.jpg" alt="Splash Image">
    </div>
</section>

<style>
    .splash-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff; 
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .splash-image img {
        max-width: 100%;
        max-height: 100%;
    }
    .rev_slider_wrapper {
        position: relative;
    }
    .rev_slider {
        position: relative;
        z-index: 1;
    }
</style>

<script>
    async function SliderList() {
        try {
            const res = await axios.get('/slider-list');
            const slides = res.data.data;

            const sliderList = document.getElementById('slider-list');

            sliderList.innerHTML = '';

            slides.forEach(slide => {
                const slideElement = document.createElement('li');
                slideElement.setAttribute('data-index', slide.id);
                slideElement.setAttribute('data-transition', 'random');
                slideElement.setAttribute('data-slotamount', 'default');
                slideElement.setAttribute('data-easein', 'default');
                slideElement.setAttribute('data-easeout', 'default');
                slideElement.setAttribute('data-masterspeed', 'default');
                slideElement.setAttribute('data-thumb', `/upload/slider/${slide.image}`);
                slideElement.setAttribute('data-rotate', '0');
                slideElement.setAttribute('data-saveperformance', 'off');
                slideElement.setAttribute('data-title', slide.title);
                slideElement.setAttribute('data-description', '');

                slideElement.innerHTML = `
                    <img src="/upload/slider/${slide.image}" alt="Slide image" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">
                    <div class="tp-caption NotGeneric-Title tp-resizeme" id="slide-${slide.id}-layer-1" data-x="center" data-hoffset="" data-y="center" data-voffset="-50" data-width="['auto','auto','auto','auto']" data-height="['auto','auto','auto','auto']" data-transform_idle="o:1;" data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" data-start="1000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 5; white-space: normal; font-size: 16px; line-height: 24px;margin-bottom:20px;font-weight:normal;">
                        <div class="smooth-textbox">
                            <h1>${slide.title}</h1>
                            <p>${slide.description}</p>
                        </div>
                    </div>
                    <div class="tp-caption NotGeneric-Title tp-resizeme" id="slide-${slide.id}-layer-3" data-x="center" data-hoffset="" data-y="center" data-voffset="100" data-width="['auto','auto','auto','auto']" data-height="['auto','auto','auto','auto']" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;" data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;" data-start="3000" data-splitin="none" data-splitout="none" data-responsive_offset="on" style="z-index: 7; white-space: nowrap; font-size: 16px; line-height: 50px;font-weight:500;text-align:center;">
                    </div>
                `;
                sliderList.appendChild(slideElement);
            });

            document.getElementById('splash-image').style.display = 'none';

            if (typeof RevSlider !== 'undefined') {
                RevSlider.refresh();
            }

        } catch (error) {
            console.error('Error loading slider data:', error);
    } 
}

SliderList();
</script>

