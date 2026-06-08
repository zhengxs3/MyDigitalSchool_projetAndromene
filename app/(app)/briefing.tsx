import {
  BriefingType,
  getPartyBriefing,
} from "@/hooks/usePlayer";

import { router, useLocalSearchParams } from "expo-router";
import React, { useEffect, useState } from "react";
import {
  ActivityIndicator,
  Platform,
  ScrollView,
  StyleSheet,
  Text,
  View,
} from "react-native";

export default function Briefing() {
  const { roomId, partyId } = useLocalSearchParams();

  const [briefing, setBriefing] = useState<BriefingType | null>(null);
  const [loading, setLoading] = useState(true);
  const [secondsLeft, setSecondsLeft] = useState(15);

  const backendUrl = process.env.EXPO_PUBLIC_BACKEND_URI;

  const loadBriefing = async () => {
    try {
      if (!backendUrl) {
        console.log("Backend URL manquante");
        return;
      }

      const briefingData = await getPartyBriefing(
        partyId,
        backendUrl
      );

      if (!briefingData) {
        return;
      }

      setBriefing(briefingData);
      setSecondsLeft(briefingData.time_limit ?? 15);
    } catch (error) {
      console.log("Erreur briefing :", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadBriefing();
  }, []);

  useEffect(() => {
    if (loading || !briefing) return;

    if (secondsLeft <= 0) {
      router.replace({
        pathname: "/(app)/ressources",
        params: {
          roomId,
          partyId,
        },
      });
      return;
    }

    const timer = setTimeout(() => {
      setSecondsLeft((prev) => prev - 1);
    }, 1000);

    return () => clearTimeout(timer);
  }, [secondsLeft, loading, briefing]);

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#2525F2" />
        <Text style={styles.loadingText}>Chargement du briefing...</Text>
      </View>
    );
  }

  if (!briefing) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={styles.loadingText}>Aucun briefing trouvé</Text>
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

      <Text style={styles.kicker}>CEO BRIEFING</Text>

      <Text style={styles.title}>Mission du CEO</Text>

      <Text style={styles.subtitle}>
        Le briefing disparaîtra automatiquement à la fin du compte à rebours.
      </Text>

      <View style={styles.timerCircle}>
        <Text style={styles.timerNumber}>{secondsLeft}</Text>
        <Text style={styles.timerLabel}>secondes</Text>
      </View>

      <View style={styles.card}>
        <Text style={styles.briefingTitle}>{briefing.title}</Text>

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>📢 DEMANDE DU CEO</Text>
          <Text style={styles.infoText}>{briefing.content}</Text>
        </View>

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>🎯 OBJECTIF</Text>
          <Text style={styles.infoText}>{briefing.objective}</Text>
        </View>

        <View style={styles.warningBlock}>
          <Text style={styles.warningText}>
            Analysez vite. Après {briefing.time_limit} secondes, la mission sera
            masquée.
          </Text>
        </View>
      </View>
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
    marginBottom: 42,
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
    fontSize: 30,
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

  timerCircle: {
    alignSelf: "center",
    marginTop: 26,
    width: 96,
    height: 96,
    borderRadius: 48,
    backgroundColor: "#2525F2",
    justifyContent: "center",
    alignItems: "center",
    shadowColor: "#2525F2",
    shadowOpacity: 0.25,
    shadowRadius: 14,
    shadowOffset: {
      width: 0,
      height: 8,
    },
    elevation: 8,
  },

  timerNumber: {
    color: "#FFFFFF",
    fontSize: 32,
    fontWeight: "900",
  },

  timerLabel: {
    color: "#FFFFFF",
    fontSize: 11,
    fontWeight: "700",
  },

  card: {
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

  briefingTitle: {
    marginBottom: 22,
    fontSize: 30,
    fontWeight: "900",
    textAlign: "center",
    color: "#151936",
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
    fontSize: 15,
    lineHeight: 22,
    fontWeight: "600",
  },

  warningBlock: {
    marginTop: 4,
    backgroundColor: "#151936",
    borderRadius: 14,
    padding: 14,
  },

  warningText: {
    color: "#FFFFFF",
    fontSize: 13,
    lineHeight: 19,
    fontWeight: "700",
    textAlign: "center",
  },
});