import { generateResources } from "@/constants/resources";
import { getCurrentPlayer } from "@/hooks/usePlayer";
import { router, useLocalSearchParams } from "expo-router";
import React, { useEffect, useState } from "react";
import {
    ActivityIndicator,
    SafeAreaView,
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from "react-native";

type RessourcesType = {
  argent: number;
  informations: number;
  influence: number;
  cartesSabotage: number;
  shield: number;
};

export default function Ressources() {
  const { roomId, partyId } = useLocalSearchParams();

  const [ressources, setRessources] =
    useState<RessourcesType | null>(null);

  const [loading, setLoading] = useState(true);

  const backendUrl = process.env.EXPO_PUBLIC_BACKEND_URI;

  const loadUserAndResources = async () => {
    try {
      if (!backendUrl) {
        console.log("Backend URL manquante");
        return;
      }

      const result = await getCurrentPlayer(
        roomId,
        backendUrl
      );

      if (!result) {
        return;
      }

      const { user, player } = result;

      console.log("currentPlayer =", player);
      console.log("resources from API =", player.resources);

      const rawResources = player.resources;

      const hasResources =
        rawResources !== null &&
        rawResources !== undefined &&
        rawResources !== "" &&
        rawResources !== "[]" &&
        !(Array.isArray(rawResources) &&
          rawResources.length === 0);

      if (hasResources) {
        const savedResources =
          typeof rawResources === "string"
            ? JSON.parse(rawResources)
            : rawResources;

        setRessources(savedResources as RessourcesType);

        return;
      }

      const generatedResources = generateResources();

      const saveResponse = await fetch(
        `${backendUrl}/party-players/update-ressources`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            party_id: partyId,
            user_id: user.id,
            ressources: generatedResources,
          }),
        }
      );

      const saveData = await saveResponse.json();

      console.log("Ressources saved =", saveData);

      if (!saveResponse.ok) {
        console.log(
          "Erreur lors de la sauvegarde des ressources"
        );
        return;
      }

      setRessources(generatedResources);
    } catch (error) {
      console.log("Erreur ressources :", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadUserAndResources();
  }, []);

  const handleContinue = () => {
    router.replace({
      pathname: "/(app)/decisions",
      params: {
        roomId,
        partyId,
      },
    });
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator
          size="large"
          color="#2525F2"
        />

        <Text style={styles.loadingText}>
          Attribution des ressources...
        </Text>
      </View>
    );
  }

  if (!ressources) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={styles.errorTitle}>
          Ressources introuvables
        </Text>

        <Text style={styles.errorText}>
          Impossible d’attribuer vos ressources.
        </Text>
      </View>
    );
  }

  return (
    <SafeAreaView style={styles.container}>
      <ScrollView
        contentContainerStyle={styles.content}
      >
        <Text style={styles.title}>
          Ressources Initiales
        </Text>

        <Text style={styles.subtitle}>
          Le conseil d’administration a alloué vos
          ressources de départ. Utilisez-les
          stratégiquement.
        </Text>

        <View style={styles.card}>
          <View style={styles.left}>
            <Text style={styles.icon}>💰</Text>
          </View>

          <View style={styles.center}>
            <Text style={styles.label}>ARGENT</Text>

            <Text style={styles.value}>
              {ressources.argent.toLocaleString()} €
            </Text>
          </View>
        </View>

        <View style={styles.card}>
          <View style={styles.left}>
            <Text style={styles.icon}>🕵️</Text>
          </View>

          <View style={styles.center}>
            <Text style={styles.label}>
              INFORMATIONS
            </Text>

            <Text style={styles.value}>
              {ressources.informations}
            </Text>
          </View>
        </View>

        <View style={styles.card}>
          <View style={styles.left}>
            <Text style={styles.icon}>⭐</Text>
          </View>

          <View style={styles.center}>
            <Text style={styles.label}>INFLUENCE</Text>

            <Text style={styles.value}>
              {ressources.influence}
            </Text>
          </View>
        </View>

        <View style={styles.card}>
          <View style={styles.left}>
            <Text style={styles.icon}>💣</Text>
          </View>

          <View style={styles.center}>
            <Text style={styles.label}>
              CARTES SABOTAGE
            </Text>

            <Text style={styles.value}>
              {ressources.cartesSabotage}
            </Text>
          </View>
        </View>

        <View style={styles.card}>
          <View style={styles.left}>
            <Text style={styles.icon}>🛡️</Text>
          </View>

          <View style={styles.center}>
            <Text style={styles.label}>SHIELD</Text>

            <Text style={styles.value}>
              {ressources.shield}
            </Text>
          </View>
        </View>

        <TouchableOpacity
          style={styles.button}
          onPress={handleContinue}
        >
          <Text style={styles.buttonText}>
            Confirmer et Continuer
          </Text>
        </TouchableOpacity>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  loadingContainer: {
    flex: 1,
    backgroundColor: "#F5F2FF",
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
    flex: 1,
    backgroundColor: "#F5F2FF",
  },

  content: {
    padding: 20,
    paddingBottom: 40,
  },

  title: {
    fontSize: 32,
    fontWeight: "800",
    color: "#111827",
    marginBottom: 12,
  },

  subtitle: {
    fontSize: 15,
    color: "#6B7280",
    lineHeight: 22,
    marginBottom: 30,
  },

  card: {
    backgroundColor: "#FFFFFF",
    borderRadius: 18,
    padding: 18,
    marginBottom: 16,

    flexDirection: "row",
    alignItems: "center",

    shadowColor: "#000",
    shadowOpacity: 0.05,
    shadowRadius: 8,
    shadowOffset: {
      width: 0,
      height: 4,
    },

    elevation: 2,
  },

  left: {
    width: 58,
    height: 58,
    borderRadius: 14,
    backgroundColor: "#EEF2FF",

    justifyContent: "center",
    alignItems: "center",

    marginRight: 16,
  },

  icon: {
    fontSize: 28,
  },

  center: {
    flex: 1,
  },

  label: {
    fontSize: 12,
    fontWeight: "700",
    color: "#9CA3AF",
    marginBottom: 6,
    letterSpacing: 1,
  },

  value: {
    fontSize: 28,
    fontWeight: "800",
    color: "#111827",
  },

  button: {
    marginTop: 20,
    backgroundColor: "#3B35FF",
    paddingVertical: 18,
    borderRadius: 14,

    alignItems: "center",
  },

  buttonText: {
    color: "#FFFFFF",
    fontSize: 16,
    fontWeight: "700",
  },
});