// motion arrow wire
const btns = document.querySelectorAll(".btn");
const slideRow = document.getElementById("slide-row");
const main = document.querySelector("main");

let currentIndex = 0;

function updateSlide() {
    const mainWidth = main.offsetWidth;
    const translateValue = currentIndex * -mainWidth;
    slideRow.style.transform = `translateX(${translateValue}px)`;

    btns.forEach((btn, index) => {
        btn.classList.toggle("active", index === currentIndex);
    });
}

btns.forEach((btn, index) => {
    btn.addEventListener("click", () => {
        currentIndex = index;
        updateSlide();
    });
});

window.addEventListener("resize", () => {
    updateSlide();
});

function toggleAccordion(element) {
    const arrow = element.querySelector(".q_a_cards_header_title_arrow i");
    const footer = element.nextElementSibling;

    if (footer.style.display === "none" || footer.style.display === "") {
        // Show the footer
        footer.style.display = "block";
        setTimeout(() => {
            footer.classList.add("show");
            footer.classList.remove("hide");
        }, 10); // Allow DOM to update before applying the animation

        // Rotate the arrow
        arrow.parentElement.classList.add("rotate");
    } else {
        // Hide the footer
        footer.classList.add("hide");
        footer.classList.remove("show");
        setTimeout(() => {
            footer.style.display = "none";
        }, 500); // Match the CSS transition duration

        // Reset the arrow rotation
        arrow.parentElement.classList.remove("rotate");
    }
}
// map
