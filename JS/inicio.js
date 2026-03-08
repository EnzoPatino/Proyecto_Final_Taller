const hero = document.querySelector(".hero-content");

hero.addEventListener("mouseenter", () => {
    hero.classList.add("hover");
});

hero.addEventListener("mouseleave", () => {
    hero.classList.remove("hover");
});