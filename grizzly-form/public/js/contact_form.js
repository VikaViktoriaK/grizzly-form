document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("contactForm");
    const submitBtn = document.getElementById("submitBtn");
    const successMessage = document.getElementById("successMessage");

    const phonePlaceholder = document.getElementById("phonePlaceholder");
    const phoneList = document.getElementById("phoneList");
    const openPhoneBtn = document.getElementById("openPhone");

    const about = document.getElementById("about");

    const maxRows = 7;

    about.addEventListener("input", function () {
        const lineHeight = parseFloat(getComputedStyle(this).lineHeight);
        const maxHeight = lineHeight * maxRows;

        this.style.height = "auto";
        this.style.height = Math.min(this.scrollHeight, maxHeight) + "px";
    });

    about.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && about.value.split("\n").length >= maxRows) {
            e.preventDefault();
        }
    });

    openPhoneBtn.addEventListener("click", () => {
        phonePlaceholder.classList.add("d-none");
        phoneList.classList.remove("d-none");
        phoneList.querySelector(".phone-input").focus();
    });

    phoneList.addEventListener("click", (e) => {
        if (!e.target.classList.contains("add-more")) return;

        const rows = phoneList.querySelectorAll(".phone-row");
        if (rows.length >= 5) return;

        const countryCode =
            phoneList.querySelector('input[name="country_code"]:checked')
                ?.value || "+375";

        const mask = phoneMasks[countryCode];

        const newRow = document.createElement("div");
        newRow.className = "phone-row";

        newRow.innerHTML = `
        <input
            type="tel"
            class="form-control phone-input"
            data-mask="${mask}"
            value="${mask}"
        />
        <button type="button" class="btn-add-phone add-more">+</button>
    `;

        phoneList.appendChild(newRow);
    });

    const phoneMasks = {
        "+375": "+375(__) ___ __ __",
        "+7": "+7(___) ___-__-__",
    };

    function formatPhone(value, mask) {
        let i = 0;
        return mask.replace(/_/g, () => value[i++] || "_");
    }

    document.addEventListener("input", (e) => {
        if (!e.target.classList.contains("phone-input")) return;

        const mask = e.target.dataset.mask;

        let digits = e.target.value.replace(/\D/g, "");

        if (mask.startsWith("+375")) {
            digits = digits.replace(/^375/, "");
        }

        if (mask.startsWith("+7")) {
            digits = digits.replace(/^7/, "");
        }

        e.target.value = formatPhone(digits, mask);
    });

    function initFirstPhoneMask() {
        const firstPhone = document.querySelector(".phone-input");
        if (!firstPhone) return;

        const countryCode =
            document.querySelector('input[name="country_code"]:checked')
                ?.value || "+375";

        const mask = phoneMasks[countryCode];

        firstPhone.dataset.mask = mask;
        firstPhone.value = mask;
    }

    initFirstPhoneMask();

    const countrySelect = document.querySelector(".country-select");
    const countryToggle = document.getElementById("countryToggle");
    const currentFlag = document.querySelector(".current-flag");

    countryToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        countrySelect.classList.toggle("open");
    });

    document.addEventListener("click", () => {
        countrySelect.classList.remove("open");
    });

    countrySelect.querySelectorAll('input[type="radio"]').forEach((radio) => {
        radio.addEventListener("change", () => {
            currentFlag.src = radio.nextElementSibling.src;

            document.querySelectorAll(".phone-input").forEach((p) => {
                p.dataset.mask = phoneMasks[radio.value];
                p.value = phoneMasks[radio.value];
            });

            countrySelect.classList.remove("open");
        });
    });

    document.querySelectorAll(".phone-input").forEach((p) => {
        p.dataset.mask =
            phoneMasks[countrySelect.querySelector("input:checked").value];
    });

    const selectBox = document.querySelector(".selectBox");
    const radioOptions = document.getElementById("radioOptions");
    const radioSelect = document.querySelector(".radio-select");

    function toggleRadios() {
        const isOpen = radioOptions.style.display === "block";
        radioOptions.style.display = isOpen ? "none" : "block";
        radioSelect.classList.toggle("open", !isOpen);
    }

    selectBox.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleRadios();
    });

    document.addEventListener("click", function (e) {
        if (!radioSelect.contains(e.target)) {
            radioOptions.style.display = "none";
            radioSelect.classList.remove("open");
        }
    });

    document
        .querySelectorAll(".radio-group input[type='radio']")
        .forEach((radio) => {
            radio.addEventListener("change", function () {
                selectBox.textContent = this.nextElementSibling.textContent;
                radioOptions.style.display = "none";
                radioSelect.classList.remove("open");
                checkForm();
            });
        });

    function checkForm() {
        const firstName = form.first_name.value.trim();
        const lastName = form.last_name.value.trim();
        const birthDate = form.birth_date.value;
        const agreed = form.agreed.checked;
        const maritalStatus = form.marital_status.value;

        const email = form.email.value.trim();
        const phones = Array.from(form.querySelectorAll(".phone-input"))
            .map((p) => p.value.replace(/\D/g, ""))
            .filter(Boolean);

        const hasContact = email || phones.length > 0;

        submitBtn.disabled = !(
            firstName &&
            lastName &&
            birthDate &&
            maritalStatus &&
            agreed &&
            hasContact
        );
    }

    form.addEventListener("input", checkForm);

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = new FormData(form);
        data.append(
            "_token",
            document.querySelector('meta[name="csrf-token"]').content,
        );

        form.querySelectorAll(".phone-input").forEach((input) => {
            const val = input.value.replace(/\D/g, "");
            if (val) data.append("phone[]", val);
        });

        try {
            const response = await fetch("/contact/submit", {
                method: "POST",
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: data,
            });

            const json = await response.json();

            if (json.success) {
                form.style.display = "none";
                successMessage.style.display = "block";
            }
        } catch (err) {
            alert("Ошибка отправки формы");
            console.error(err);
        }
    });
});

document.querySelectorAll(".phone-row").forEach((row) => {
    const countryToggle = row.querySelector(".country-current");
    const countryFlag = row.querySelector(".current-flag");
    const countryPanel = row.querySelector(".country-panel");
    const countryOptions = row.querySelectorAll(".country-option input");

    countryToggle.addEventListener("click", () => {
        const isOpen = countryPanel.classList.toggle("open");
        row.classList.toggle("selecting-country", isOpen);
    });

    countryOptions.forEach((option) => {
        option.addEventListener("change", () => {
            const img = option.nextElementSibling;
            if (img) {
                countryFlag.src = img.src;
            }
            countryPanel.classList.remove("open");
            row.classList.remove("selecting-country");
        });
    });
});
