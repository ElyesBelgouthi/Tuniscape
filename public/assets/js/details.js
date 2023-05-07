const h1 = document.querySelector(".banner--title");
const banner = document.querySelector("#banner");
const button = document.querySelector(".learn--more");

document.addEventListener("scroll", function (event) {
    const scrollPosition = event.target.scrollingElement.scrollTop;
    if (scrollPosition > 150) {
        banner.style.backgroundSize = "150%";
        h1.style.opacity = 0;
        h1.style.translate = "0-50px";
        h1.style.scale = "0.9";
        button.style.opacity = 0;
        button.style.translate = "0 -40px";
        button.style.scale = "0.8";
    } else {
        banner.style.backgroundSize = "180%";
        h1.style.opacity = 1;
        h1.style.translate = 0;
        h1.style.scale = 1;
        button.style.opacity = 1;
        button.style.translate = 0;
        button.style.scale = 1;
    }
});

const items = document.querySelectorAll(".item");

const expand = (item, i) => {
    items.forEach((it, ind) => {
        if (i === ind) return;
        it.clicked = false;
    });
    gsap.to(items, {
        width: item.clicked ? "15vw" : "8vw",
        duration: 2,
        ease: "elastic(1, .6)",
    });

    item.clicked = !item.clicked;
    gsap.to(item, {
        width: item.clicked ? "42vw" : "15vw",
        duration: 2.5,
        ease: "elastic(1, .3)",
    });
};

items.forEach((item, i) => {
    item.clicked = false;
    item.addEventListener("click", () => expand(item, i));
});
