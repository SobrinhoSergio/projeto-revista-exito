//mobile
document.querySelector('.menu-open').onclick = function() {
    document.documentElement.classList.add('menu-active');
};

document.querySelector('.menu-close').onclick = function() {
    document.documentElement.classList.remove('menu-active');
};

document.documentElement.onclick = function(event) {
    if (event.target === document.documentElement) {
        document.documentElement.classList.remove('menu-active');
    }
};

// dropdown list
let acc = document.getElementsByClassName("cms-dropdown-btn");
let i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        let panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}

