(() => {
    // variables
    const sliderContainer = document.querySelector('.slider');
    if(!sliderContainer) return;
    const prev = document.querySelector('.prev');
    const next = document.querySelector('.next');
    const sliderItems = document.querySelectorAll('.slider__item');


    let index = 0; // Current position
    let pause = 5000;
    let interval;

    /**
     * Stop slider
     */
    const stopSlider = () => {
        clearInterval(interval);
    }
    /**
     * Toggle class active
     * @param list
     * @param i
     */
    const addClassActive = (list, i) => {
        /* remove all items class active */
        list.forEach(item => {
            item.classList.remove('active');
        });
        /* Add class active */
        list[i].classList.add('active');
    }
    /**
     *
     * @param i
     */
    const activeSlide = i => {
        addClassActive(sliderItems, i);
    }

    /**
     *
     * @param i
     */
    const prepareCurrentSlide = i => {
        activeSlide(i);
    }
    /**
     * Next
     */
    const getNext = () => {
        if ((sliderItems.length - 1) === index) {
            index = 0;
            prepareCurrentSlide(index);
        } else {
            index++;
            prepareCurrentSlide(index);
        }
    }
    /**
     * Prev
     */
    const getPrev = () => {
        if (0 === index) {
            index = sliderItems.length - 1;
            prepareCurrentSlide(index);
        } else {
            index--;
            prepareCurrentSlide(index);
        }
    }
    /**
     * Start
     */
    const start = () => {
        interval = setInterval(() => {
            getNext();
        }, pause);
    }

    next.addEventListener('click', getNext);
    prev.addEventListener('click', getPrev);

    sliderContainer.addEventListener("mouseenter", stopSlider);
    sliderContainer.addEventListener("mouseleave", start);

    start();
})();
