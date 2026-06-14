import { CurrentPlayer, getCurrentPlayer } from "@/hooks/usePlayer";
import { router, useLocalSearchParams } from "expo-router";
import { useEffect, useState } from "react";
import {
  ActivityIndicator,
  Image,
  ImageSourcePropType,
  Platform,
  ScrollView,
  StyleSheet,
  Text,
  TouchableOpacity,
  View,
} from "react-native";

import { ROLES } from "../../constants/roles";

type SecretRole = {
  id: string;
  name: string;
  image: ImageSourcePropType | null;
  objective: string;
  power: string;
};

export default function Role() {
  // Récupération des identifiants de la salle et de la partie
  const { roomId, partyId } = useLocalSearchParams();

  // Utilisateur actuellement connecté
  const [currentUser, setCurrentUser] = useState<any>(null);

  // Liste des joueurs présents dans la partie
  const [players, setPlayers] = useState<CurrentPlayer[]>([]);

  // Rôle secret attribué au joueur
  const [myRole, setMyRole] = useState<SecretRole | null>(null);

  // État de chargement de la page
  const [loading, setLoading] = useState(true);

  const backendUrl = process.env.EXPO_PUBLIC_BACKEND_URI;

  /**
   * Charge les informations du joueur et récupère son rôle.
   * Si aucun rôle n'est encore enregistré, un rôle aléatoire
   * est généré puis sauvegardé dans la base de données.
   */
  const loadUserAndRole = async () => {
    try {
      if (!backendUrl) {
        console.log("Backend URL manquante");
        return;
      }

      const result = await getCurrentPlayer(roomId, backendUrl);

      if (!result) {
        return;
      }

      const { user, player, players } = result;

      setCurrentUser(user);
      setPlayers(players);

      if (player.role) {
        const savedRole = ROLES.find((role) => role.id === player.role);

        if (savedRole) {
          setMyRole(savedRole);
          return;
        }
      }

      const randomIndex = Math.floor(Math.random() * ROLES.length);
      const randomRole = ROLES[randomIndex];

      const response = await fetch(`${backendUrl}/party-players/update-role`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          party_id: partyId,
          user_id: user.id,
          role: randomRole.id,
        }),
      });

      if (!response.ok) {
        console.log("Erreur lors de la sauvegarde du rôle");
        return;
      }

      setMyRole(randomRole);
    } catch (error) {
      console.log(error);
    } finally {
      setLoading(false);
    }
  };

  // Chargement du rôle lors de l'ouverture de la page.
  useEffect(() => {
    loadUserAndRole();
  }, []);

  // Validation du rôle et passage à l'écran de briefing.
  const handleContinue = () => {
    router.replace({
      pathname: "/(app)/briefing",
      params: {
        roomId,
        partyId,
      },
    });
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#2525F2" />
        <Text style={styles.loadingText}>Attribution du rôle...</Text>
      </View>
    );
  }

  if (!myRole) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={styles.errorTitle}>Rôle introuvable</Text>
        <Text style={styles.errorText}>
          Impossible d’attribuer votre rôle secret.
        </Text>
      </View>
    );
  }

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <View style={styles.header}>
        <Text style={styles.menu}>☰</Text>
        <Text style={styles.logo}>BestNegotiator</Text>
        <View style={styles.avatar} />
      </View>

      <Text style={styles.kicker}>MISSION CONFIDENTIELLE</Text>

      <Text style={styles.title}>Votre Rôle Secret</Text>

      <Text style={styles.subtitle}>
        Personne ne doit voir cet écran à part vous.
      </Text>

      <View style={styles.roleCard}>
        <Text style={styles.roleName}>{myRole.name}</Text>

        <View style={styles.imageBox}>
          {myRole.image ? (
            <Image source={myRole.image} style={styles.roleImage} />
          ) : (
            <Text style={styles.imagePlaceholder}>🎭</Text>
          )}
        </View>

        <View style={styles.separator} />

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>🎯 OBJECTIF</Text>
          <Text style={styles.infoText}>{myRole.objective}</Text>
        </View>

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>⚡ POUVOIR</Text>
          <Text style={styles.infoText}>{myRole.power}</Text>
        </View>
      </View>

      <TouchableOpacity style={styles.button} onPress={handleContinue}>
        <Text style={styles.buttonText}>Compris, je commence ›</Text>
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
    padding: 24,
  },

  loadingText: {
    marginTop: 12,
    color: "#151936",
    fontWeight: "700",
    fontSize: 15,
  },

  errorTitle: {
    fontSize: 22,
    fontWeight: "900",
    color: "#151936",
  },

  errorText: {
    marginTop: 8,
    color: "#6B7280",
    textAlign: "center",
    fontSize: 14,
  },

  container: {
    flexGrow: 1,
    backgroundColor: "#F8F5FF",
    paddingHorizontal: 20,
    paddingTop: Platform.OS === "web" ? 24 : 44,
    paddingBottom: 30,
  },

  header: {
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "space-between",
    marginBottom: 60,
  },

  menu: {
    fontSize: 22,
    color: "#2525F2",
    fontWeight: "900",
  },

  logo: {
    fontSize: 24,
    fontWeight: "900",
    color: "#0B00C7",
  },

  avatar: {
    width: 34,
    height: 34,
    borderRadius: 17,
    backgroundColor: "#151936",
  },

  kicker: {
    textAlign: "center",
    color: "#2525F2",
    fontSize: 11,
    fontWeight: "900",
    letterSpacing: 1.2,
  },

  title: {
    textAlign: "center",
    marginTop: 6,
    fontSize: 28,
    fontWeight: "900",
    color: "#151936",
  },

  subtitle: {
    textAlign: "center",
    marginTop: 10,
    color: "#6B7280",
    fontSize: 13,
    lineHeight: 18,
  },

  roleCard: {
    marginTop: 30,
    backgroundColor: "#FFFFFF",
    borderRadius: 18,
    padding: 18,
    shadowColor: "#2525F2",
    shadowOpacity: 0.15,
    shadowRadius: 18,
    shadowOffset: {
      width: 0,
      height: 10,
    },
    elevation: 8,
  },

  imageBox: {
    height: 180,
    borderRadius: 14,
    backgroundColor: "#F1F1F8",
    justifyContent: "center",
    alignItems: "center",
    overflow: "hidden",
  },

  roleImage: {
    width: "100%",
    height: "100%",
    resizeMode: "cover",
  },

  imagePlaceholder: {
    fontSize: 48,
  },

  roleName: {
    marginBottom: 22,
    fontSize: 30,
    fontWeight: "900",
    textAlign: "center",
    color: "#151936",
  },

  separator: {
    height: 1,
    backgroundColor: "#D8D4E8",
    marginVertical: 22,
  },

  infoBlock: {
    backgroundColor: "#F6F4FF",
    borderRadius: 14,
    padding: 15,
    marginBottom: 14,
  },

  infoTitle: {
    color: "#2525F2",
    fontSize: 12,
    fontWeight: "900",
    marginBottom: 7,
  },

  infoText: {
    color: "#151936",
    fontSize: 14,
    lineHeight: 21,
    fontWeight: "600",
  },

  button: {
    marginTop: 28,
    height: 54,
    borderRadius: 12,
    backgroundColor: "#2525F2",
    justifyContent: "center",
    alignItems: "center",
    shadowColor: "#2525F2",
    shadowOpacity: 0.25,
    shadowRadius: 12,
    shadowOffset: {
      width: 0,
      height: 8,
    },
    elevation: 6,
  },

  buttonText: {
    color: "#FFFFFF",
    fontWeight: "900",
    fontSize: 15,
  },
});