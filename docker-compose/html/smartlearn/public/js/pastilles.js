document.addEventListener("click", function (e) {

    // Vérifie que l’élément cliqué est une pastille cliquable
    if (!e.target.classList.contains("pastille")) return;
    if (!e.target.classList.contains("clickable")) return;

    let p = e.target;

    // Récupération des infos de la pastille
    let enrollmentStatus_id = p.dataset.id;     // ex: 12
    let name = p.dataset.name;            // ex: "paiement_status"
    let state = p.dataset.state;          // ex: "white"

    // Cycle des couleurs
    let newState =
        state === "white" ? "green" :
        state === "green" ? "red" :
        "white";

    // Mise à jour visuelle immédiate
    p.dataset.state = newState;
    p.classList.remove("white", "green", "red");
    p.classList.add(newState);

    // Envoi AJAX
    fetch("update-pastille", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id: enrollmentStatus_id,
            name: name,
            state: newState
        })
    })
    .then(response => response.json())
    .then(data => {

        console.log("Réponse du serveur :", data);

        // Vérification du succès
        if (data.success) {

            // Sélecteur précis pour retrouver la pastille
            const el = document.querySelector(
                `[data-id="${data.id}"][data-name="${data.name}"]`
            );

            if (el) {
                el.dataset.state = data.state;
                el.classList.remove("white", "green", "red");
                el.classList.add(data.state);
            }
        }
    })
    .catch(err => console.error("Erreur fetch :", err));
});
