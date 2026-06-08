import AsyncStorage from "@react-native-async-storage/async-storage";

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

export type BriefingType = {
  id: number;
  title: string;
  content: string;
  objective: string;
  time_limit: number;
};

export async function getCurrentPlayer(
  roomId: string | string[],
  backendUrl: string
): Promise<{
  user: any;
  player: CurrentPlayer;
  players: CurrentPlayer[];
} | null> {
  const userString = await AsyncStorage.getItem("user");

  if (!userString) {
    return null;
  }

  const user = JSON.parse(userString);

  const response = await fetch(
    `${backendUrl}/rooms/waiting-room/${roomId}?user_id=${user.id}`
  );

  const data = await response.json();

  if (!response.ok) {
    return null;
  }

  const players: CurrentPlayer[] = data.players ?? [];

  const player = players.find(
    (p) => Number(p.user_id) === Number(user.id)
  );

  if (!player) {
    return null;
  }

  return {
    user,
    player,
    players,
  };
}


export async function getPartyBriefing(
  partyId: string | string[],
  backendUrl: string
): Promise<BriefingType | null> {
  const response = await fetch(
    `${backendUrl}/parties/${partyId}/briefing`
  );

  const data = await response.json();

  if (!response.ok) {
    return null;
  }

  return data.briefing;
}