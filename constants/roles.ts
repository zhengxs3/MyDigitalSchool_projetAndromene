export const ROLES = [
  {
    id: "manipulateur",
    name: "Manipulateur",
    image: null, // image: require("../assets/images/roles/manipulateur.png")
    objective: "Créer le chaos et perturber les autres joueurs",
    power: "1 carte sabotage au début de chaque round",
  },

  {
    id: "diplomate",
    name: "Diplomate",
    image: null,
    objective: "Obtenir des avantages grâce à la négociation",
    power: "Peut échanger des ressources à un meilleur taux",
  },

  {
    id: "stratege",
    name: "Stratège",
    image: null,
    objective: "Construire le projet le plus cohérent possible",
    power: "Voit 1 critère du briefing pendant toute la partie",
  },

  {
    id: "saboteur",
    name: "Saboteur",
    image: null,
    objective: "Déstabiliser les adversaires",
    power: "Cooldown des sabotages réduit de 25%",
  },

  {
    id: "influenceur",
    name: "Influenceur",
    image: null,
    objective: "Maximiser son impact et son score final",
    power: "Commence avec +20 Influence",
  },
];