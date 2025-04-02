function showModal(title, message) {
  const modalElement = document.getElementById("customModal");
  const modalTitle = document.getElementById("customModalTitle");
  const modalBody = document.getElementById("customModalBody");

  if (!modalElement || !modalTitle || !modalBody) return;

  modalTitle.innerText = title;
  modalBody.innerText = message;

  const modal = new bootstrap.Modal(modalElement);
  modal.show();
}

function confirmModalPromise(title, message) {
  return new Promise((resolve) => {
    const modalElement = document.getElementById("confirmModal");
    const modalTitle = document.getElementById("confirmModalTitle");
    const modalBody = document.getElementById("confirmModalBody");
    const confirmBtn = document.getElementById("confirmModalYes");
    const cancelBtn = modalElement.querySelector('[data-bs-dismiss="modal"]');

    if (!modalElement || !modalTitle || !modalBody || !confirmBtn)
      return resolve(false);

    modalTitle.innerText = title;
    modalBody.innerText = message;

    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    // Reset old listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

    newConfirmBtn.addEventListener("click", () => {
      modal.hide();
      resolve(true);
    });

    cancelBtn.addEventListener("click", () => {
      resolve(false);
    });
  });
}
