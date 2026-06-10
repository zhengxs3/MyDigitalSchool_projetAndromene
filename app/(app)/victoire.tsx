import { router, useLocalSearchParams } from "expo-router";
import { useEffect, useState } from "react";
import {
    ActivityIndicator,
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from "react-native";

type RankingPlayer = {
  id: number;
  user_id: number;
  pseudo: string;
  role: string;
  score: number;
  rank: number;
};

export default function Victoire() {
  const { partyId } = useLocalSearchParams();

  const [players, setPlayers] = useState<RankingPlayer[]>([]);
  const [loading, setLoading] = useState(true);

  const backendUrl = process.env.EXPO_PUBLIC_BACKEND_URI;

  const loadRanking = async () => {
    try {
      if (!backendUrl || !partyId) return;

      const response = await fetch(`${backendUrl}/player-decisions/ranking/${partyId}`);
      const data = await response.json();

      if (data.success) {
        setPlayers(data.players ?? []);
      }
    } catch (error) {
      console.log("Erreur ranking :", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadRanking();
  }, []);

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#2525F2" />
        <Text style={styles.loadingText}>Chargement du classement...</Text>
      </View>
    );
  }

  const first = players[0];
  const second = players[1];
  const third = players[2];

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.logo}>BestNegotiator</Text>

      <Text style={styles.title}>Victoire Stratégique !</Text>
      <Text style={styles.subtitle}>Classement final selon les scores.</Text>

      <View style={styles.podium}>
        <View style={styles.podiumItem}>
          <View style={styles.avatarSmall} />
          <View style={styles.podiumBlockSecond}>
            <Text style={styles.rankNumber}>2</Text>
            <Text style={styles.playerName}>{second?.pseudo ?? "Joueur 2"}</Text>
            <Text style={styles.score}>{second?.score ?? 0} pts</Text>
          </View>
        </View>

        <View style={styles.podiumItem}>
          <View style={styles.avatarBig} />
          <View style={styles.podiumBlockFirst}>
            <Text style={styles.rankNumberFirst}>1</Text>
            <Text style={styles.playerNameFirst}>{first?.pseudo ?? "Joueur 1"}</Text>
            <Text style={styles.scoreFirst}>{first?.score ?? 0} pts</Text>
          </View>
        </View>

        <View style={styles.podiumItem}>
          <View style={styles.avatarSmall} />
          <View style={styles.podiumBlockThird}>
            <Text style={styles.rankNumber}>3</Text>
            <Text style={styles.playerName}>{third?.pseudo ?? "Joueur 3"}</Text>
            <Text style={styles.score}>{third?.score ?? 0} pts</Text>
          </View>
        </View>
      </View>

      <View style={styles.rankingBox}>
        {players.map((player) => (
          <View key={player.id} style={styles.rankingRow}>
            <Text style={styles.rankingRank}>#{player.rank}</Text>
            <View style={styles.rankingInfo}>
              <Text style={styles.rankingName}>{player.pseudo}</Text>
              <Text style={styles.rankingRole}>{player.role}</Text>
            </View>
            <Text style={styles.rankingScore}>{player.score} pts</Text>
          </View>
        ))}
      </View>

      <TouchableOpacity
        style={styles.primaryButton}
        onPress={() => router.replace("/choixsalle")}
      >
        <Text style={styles.primaryButtonText}>Retour au Menu</Text>
      </TouchableOpacity>

      <TouchableOpacity
        style={styles.primaryButton}
        onPress={() => router.replace("/attendre")}
      >
        <Text style={styles.primaryButtonText}>continuer jeu</Text>
      </TouchableOpacity>

      <TouchableOpacity style={styles.secondaryButton}>
        <Text style={styles.secondaryButtonText}>Partager le Résultat</Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  loadingContainer: {
    flex: 1,
    backgroundColor: "#F8F5FF",
    justifyContent: "center",
    alignItems: "center",
  },
  loadingText: {
    marginTop: 12,
    color: "#151936",
    fontWeight: "800",
  },
  container: {
    flexGrow: 1,
    backgroundColor: "#F8F5FF",
    padding: 24,
    paddingBottom: 40,
  },
  logo: {
    color: "#2525F2",
    fontWeight: "900",
    fontSize: 14,
    marginBottom: 24,
  },
  title: {
    textAlign: "center",
    color: "#2525F2",
    fontSize: 28,
    fontWeight: "900",
  },
  subtitle: {
    textAlign: "center",
    marginTop: 8,
    color: "#6B7280",
    fontSize: 13,
    marginBottom: 36,
  },
  podium: {
    flexDirection: "row",
    justifyContent: "center",
    alignItems: "flex-end",
    marginBottom: 32,
  },
  podiumItem: {
    alignItems: "center",
    width: 105,
  },
  avatarSmall: {
    width: 46,
    height: 46,
    borderRadius: 23,
    backgroundColor: "#151936",
    borderWidth: 3,
    borderColor: "#2525F2",
    marginBottom: 8,
  },
  avatarBig: {
    width: 64,
    height: 64,
    borderRadius: 32,
    backgroundColor: "#151936",
    borderWidth: 4,
    borderColor: "#2525F2",
    marginBottom: 8,
  },
  podiumBlockFirst: {
    height: 120,
    width: 95,
    backgroundColor: "#2525F2",
    borderTopLeftRadius: 12,
    borderTopRightRadius: 12,
    alignItems: "center",
    justifyContent: "center",
  },
  podiumBlockSecond: {
    height: 85,
    width: 95,
    backgroundColor: "#E5E7EB",
    borderTopLeftRadius: 12,
    borderTopRightRadius: 12,
    alignItems: "center",
    justifyContent: "center",
  },
  podiumBlockThird: {
    height: 70,
    width: 95,
    backgroundColor: "#E5E7EB",
    borderTopLeftRadius: 12,
    borderTopRightRadius: 12,
    alignItems: "center",
    justifyContent: "center",
  },
  rankNumber: {
    color: "#151936",
    fontSize: 22,
    fontWeight: "900",
  },
  rankNumberFirst: {
    color: "#FFFFFF",
    fontSize: 28,
    fontWeight: "900",
  },
  playerName: {
    color: "#151936",
    fontSize: 11,
    fontWeight: "800",
    marginTop: 4,
  },
  playerNameFirst: {
    color: "#FFFFFF",
    fontSize: 11,
    fontWeight: "800",
    marginTop: 4,
  },
  score: {
    color: "#6B7280",
    fontSize: 11,
    fontWeight: "800",
  },
  scoreFirst: {
    color: "#FFFFFF",
    fontSize: 11,
    fontWeight: "800",
  },
  rankingBox: {
    backgroundColor: "#FFFFFF",
    borderRadius: 18,
    padding: 14,
    marginBottom: 28,
  },
  rankingRow: {
    flexDirection: "row",
    alignItems: "center",
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: "#F1F1F1",
  },
  rankingRank: {
    width: 44,
    color: "#2525F2",
    fontSize: 18,
    fontWeight: "900",
  },
  rankingInfo: {
    flex: 1,
  },
  rankingName: {
    color: "#151936",
    fontSize: 15,
    fontWeight: "900",
  },
  rankingRole: {
    color: "#6B7280",
    fontSize: 12,
    fontWeight: "700",
    marginTop: 2,
  },
  rankingScore: {
    color: "#151936",
    fontSize: 15,
    fontWeight: "900",
  },
  primaryButton: {
    backgroundColor: "#2525F2",
    borderRadius: 12,
    paddingVertical: 16,
    alignItems: "center",
    marginBottom: 12,
  },
  primaryButtonText: {
    color: "#FFFFFF",
    fontWeight: "900",
  },
  secondaryButton: {
    backgroundColor: "#FFFFFF",
    borderRadius: 12,
    paddingVertical: 16,
    alignItems: "center",
    borderWidth: 1,
    borderColor: "#2525F2",
  },
  secondaryButtonText: {
    color: "#2525F2",
    fontWeight: "900",
  },
});