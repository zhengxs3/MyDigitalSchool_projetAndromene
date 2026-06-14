import AsyncStorage from "@react-native-async-storage/async-storage";

// Type représentant un joueur dans la partie.
export type CurrentPlayer = {
  id: number;
  user_id: number;
  name: string;
  role: string | null;
  resources?: any;
  status: string;
  isMe?: boolean;
  isHost?: boolean;
};

// Type représentant le briefing d'une partie.
export type BriefingType = {
  id: number;
  title: string;
  content: string;
  objective: string;
  time_limit: number;
};

// Récupère les informations du joueur connecté dans une salle d'attente.
export async function getCurrentPlayer(
  roomId: string | string[],
  backendUrl: string
): Promise<{
  user: any;
  player: CurrentPlayer;
  players: CurrentPlayer[];
} | null> {

  // Récupération des informations utilisateur stockées localement
  const userString = await AsyncStorage.getItem("user");

  // Si aucun utilisateur n'est trouvé, on retourne null
  if (!userString) {
    return null;
  }

  // Conversion de la chaîne JSON en objet JavaScript
  const user = JSON.parse(userString);

  // Requête vers l'API pour récupérer les données de la salle d'attente
  const response = await fetch(
    `${backendUrl}/rooms/waiting-room/${roomId}?user_id=${user.id}`
  );

  // Conversion de la réponse en JSON
  const data = await response.json();

  // Vérification du succès de la requête
  if (!response.ok) {
    return null;
  }

  // Liste des joueurs présents dans la salle
  const players: CurrentPlayer[] = data.players ?? [];

  // Recherche du joueur correspondant à l'utilisateur connecté
  const player = players.find(
    (p) => Number(p.user_id) === Number(user.id)
  );

  // Si le joueur n'est pas trouvé dans la liste
  if (!player) {
    return null;
  }

  // Retour des informations nécessaires
  return {
    user,
    player,
    players,
  };
}

// Récupère le briefing associé à une partie.
export async function getPartyBriefing(
  partyId: string | string[],
  backendUrl: string
): Promise<BriefingType | null> {
  
  // Requête pour récupérer le briefing
  const response = await fetch(
    `${backendUrl}/parties/${partyId}/briefing`
  );

  const data = await response.json();

  if (!response.ok) {
    return null;
  }

  return data.briefing;
}