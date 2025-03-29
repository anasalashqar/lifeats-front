window.generatePDF = async function () {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get("id");
  const response = await fetch(
    `http://127.0.0.1:8000/api/admin/user-subscriptions/${id}`
  );
  const sub = await response.json();

  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  doc.setFontSize(16);
  doc.text("User Subscription Report", 105, 15, null, null, "center");
  doc.setLineWidth(0.5);
  doc.line(10, 20, 200, 20);

  // Helper function
  const format = (val) => (val ? val : "N/A");

  // USER INFO
  doc.autoTable({
    startY: 30,
    head: [["User Information", ""]],
    body: [
      ["Name", format(sub.user.name)],
      ["Email", format(sub.user.email)],
      ["Phone", format(sub.user.phone)],
      ["Address", format(sub.user.address)],
      ["Preferences", format(sub.user.preferences)],
      ["Allergies", format(sub.user.allergies)],
    ],
    theme: "grid",
    headStyles: { fillColor: [41, 128, 185] },
  });

  // SUBSCRIPTION PLAN
  doc.autoTable({
    startY: doc.lastAutoTable.finalY + 10,
    head: [["Subscription Plan", ""]],
    body: [
      ["Plan Name", format(sub.subscription.name)],
      ["Goal", format(sub.subscription.goal)],
      ["Description", format(sub.subscription.description)],
      ["Duration (Days)", format(sub.subscription.duration_days)],
      ["Price", `$${format(sub.subscription.price)}`],
    ],
    theme: "grid",
    headStyles: { fillColor: [39, 174, 96] },
  });

  // SUBSCRIPTION INFO
  doc.autoTable({
    startY: doc.lastAutoTable.finalY + 10,
    head: [["Subscription Info", ""]],
    body: [
      ["Subscription ID", format(sub.id)],
      ["Start Date", format(sub.start_date)],
      ["End Date", format(sub.end_date)],
      ["Status", format(sub.status)],
      ["Created At", new Date(sub.created_at).toLocaleString()],
    ],
    theme: "grid",
    headStyles: { fillColor: [142, 68, 173] },
  });

  doc.save(`Subscription_Report_${sub.id}.pdf`);
};


