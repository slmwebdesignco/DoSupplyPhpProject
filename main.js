const DOInput = document.querySelectorAll(".do-input");

for (let i = 0; i < DOInput.length; i++) {
  let currentLabel = DOInput[i].parentElement.firstElementChild;

  if (DOInput[i].value !== "") {
    currentLabel.classList.add("slide-up");
  }

  DOInput[i].addEventListener("focus", function () {
    currentLabel.classList.add("slide-up");
  })

  DOInput[i].addEventListener("blur", function () {
    if (DOInput[i].value === "") {
      currentLabel.classList.remove("slide-up");
    }
  })
}