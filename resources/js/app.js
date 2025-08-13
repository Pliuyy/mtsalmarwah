import "flowbite";
document.addEventListener("DOMContentLoaded", function () {
    // Logic untuk dropdown "Profil" (jika Anda menggunakan JS untuk itu)
    const profileDropdownContainer = document.getElementById(
        "profile-dropdown-container"
    );
    const profileDropdownMenu = document.getElementById(
        "profile-dropdown-menu"
    );

    if (profileDropdownContainer && profileDropdownMenu) {
        let profileTimeoutId;

        profileDropdownContainer.addEventListener("mouseenter", () => {
            clearTimeout(profileTimeoutId);
            profileDropdownMenu.classList.remove("hidden");
            profileDropdownMenu.classList.add("block");
        });

        profileDropdownContainer.addEventListener("mouseleave", () => {
            profileTimeoutId = setTimeout(() => {
                profileDropdownMenu.classList.remove("block");
                profileDropdownMenu.classList.add("hidden");
            }, 200);
        });
    }

    // Logic untuk dropdown "Notifikasi"
    const notificationContainer = document.getElementById(
        "notification-bell-container"
    );
    const notificationDropdown = document.getElementById(
        "notification-dropdown"
    );
    const notificationBell = document.getElementById("notification-bell");

    if (notificationContainer && notificationDropdown && notificationBell) {
        let notificationTimeoutId;

        // Mengatur tampilan dropdown saat mouse masuk atau fokus pada tombol lonceng
        notificationContainer.addEventListener("mouseenter", () => {
            clearTimeout(notificationTimeoutId);
            notificationDropdown.classList.remove("hidden");
            notificationDropdown.classList.add("block");
        });

        // Mengatur penyembunyian dropdown saat mouse keluar
        notificationContainer.addEventListener("mouseleave", () => {
            notificationTimeoutId = setTimeout(() => {
                notificationDropdown.classList.remove("block");
                notificationDropdown.classList.add("hidden");
            }, 200); // Penundaan 200ms
        });

        // Opsional: Untuk toggle saat diklik (jika diinginkan daripada hover)
        notificationBell.addEventListener("click", (e) => {
            e.preventDefault();
            notificationDropdown.classList.toggle("hidden");
            notificationDropdown.classList.toggle("block");
        });
    }
});

function generateRandomPassword(length) {
    const chars =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+";
    let password = "";
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return password;
}
document.addEventListener("DOMContentLoaded", function () {
    const passwordDisplay = document.getElementById(
        "generated_password_display"
    );
    const passwordInputField = document.getElementById("password_input_field");
    const refreshBtn = document.getElementById("refresh_password_btn");

    if (passwordDisplay && passwordInputField && refreshBtn) {
        // Pastikan elemen ada di halaman
        // Generate initial password on load
        const initialPassword = generateRandomPassword(12);
        passwordDisplay.value = initialPassword;
        passwordInputField.value = initialPassword;

        // Generate new password on button click
        refreshBtn.addEventListener("click", function () {
            const newPassword = generateRandomPassword(12);
            passwordDisplay.value = newPassword;
            passwordInputField.value = newPassword;
        });
    }
});
