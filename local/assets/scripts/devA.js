document.addEventListener('DOMContentLoaded', () => {
    const counter = document.querySelector(`.js-counter`);
    if (counter) {
        const hoursOutput = counter.querySelector(`.counter__hours .counter__num`);
        const minutesOutput = counter.querySelector(`.counter__minutes .counter__num`);
        const secondsOutput = counter.querySelector(`.counter__seconds .counter__num`);
        const saleEndDate = counter.dataset.time;
        console.log()
        const countDownDate = new Date(`${saleEndDate}`).getTime();

        const x = setInterval(function () {
            const now = new Date().getTime();
            const distance = countDownDate - now;
            const hours = Math.floor((distance / (1000 * 60 * 60 * 24)) * 24);
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            hoursOutput.innerHTML = hours < 10 ? `0${hours}` : hours;
            minutesOutput.innerHTML = minutes < 10 ? `0${minutes}` : minutes;
            secondsOutput.innerHTML = seconds < 10 ? `0${seconds}` : seconds;
            if (distance < 0) {
                clearInterval(x);
                hoursOutput.innerHTML = '20';
                minutesOutput.innerHTML = '00';
                secondsOutput.innerHTML = '00';
            }
        }, 1000);
    }


})
