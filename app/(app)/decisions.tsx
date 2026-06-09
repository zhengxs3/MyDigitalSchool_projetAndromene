import { useLocalSearchParams } from "expo-router";
import { useEffect, useState } from "react";
import {
    ActivityIndicator,
    Platform,
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from "react-native";

type Decision = {
  id: number;
  briefing_id: number;
  content: string;
  resources_used: number;
  type: string;
  score: number;
};

type Resources = {
  argent: number;
  shield?: number;
  influence?: number;
  informations?: number;
  cartesSabotage?: number;
};

export default function Decisions() {
  const { partyId } = useLocalSearchParams();

  const [decisions, setDecisions] = useState<Decision[]>([]);
  const [resources, setResources] = useState<Resources>({
    argent: 0,
  });
  const [selectedByType, setSelectedByType] = useState<Record<string, Decision>>({});
  const [loading, setLoading] = useState(true);

  const backendUrl = process.env.EXPO_PUBLIC_BACKEND_URI;

  const loadDecisions = async () => {
    try {
      if (!backendUrl || !partyId) return;

      const response = await fetch(
        `${backendUrl}/decisions/by-party/${partyId}`
      );

      const data = await response.json();

      if (data.success) {
        setDecisions(data.decisions ?? []);

        if (data.resources) {
          const parsedResources =
            typeof data.resources === "string"
              ? JSON.parse(data.resources)
              : data.resources;

          setResources(parsedResources);
        }
      }
    } catch (error) {
      console.log("Erreur decisions :", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadDecisions();
  }, []);

  const groupedDecisions = decisions.reduce<Record<string, Decision[]>>(
    (groups, decision) => {
      if (!groups[decision.type]) {
        groups[decision.type] = [];
      }

      groups[decision.type].push(decision);
      return groups;
    },
    {}
  );

  const handleSelect = (decision: Decision) => {
    const canAfford = resources.argent >= decision.resources_used;

    if (!canAfford) return;

    setSelectedByType((prev) => ({
      ...prev,
      [decision.type]: decision,
    }));
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#2525F2" />
        <Text style={styles.loadingText}>Chargement des décisions...</Text>
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

      <Text style={styles.kicker}>DECISIONS</Text>
      <Text style={styles.title}>Cartes disponibles</Text>

      <Text style={styles.subtitle}>
        Choisissez une seule carte dans chaque catégorie.
      </Text>

      <View style={styles.resourcesBox}>
        <Text style={styles.resourcesTitle}>Vos ressources</Text>
        <Text style={styles.resourcesText}>💰 Argent : {resources.argent}</Text>
        <Text style={styles.resourcesText}>
          ⭐ Influence : {resources.influence ?? 0}
        </Text>
        <Text style={styles.resourcesText}>
          📄 Informations : {resources.informations ?? 0}
        </Text>
      </View>

      {Object.entries(groupedDecisions).map(([type, items]) => (
        <View key={type} style={styles.section}>
          <Text style={styles.sectionTitle}>{type}</Text>

          {items.map((decision) => {
            const isSelected = selectedByType[type]?.id === decision.id;
            const canAfford = resources.argent >= decision.resources_used;

            return (
              <TouchableOpacity
                key={decision.id}
                disabled={!canAfford}
                onPress={() => handleSelect(decision)}
                style={[
                  styles.card,
                  isSelected && styles.cardSelected,
                  !canAfford && styles.cardDisabled,
                ]}
              >
                <View style={styles.cardHeader}>
                  <Text style={styles.cardTitle}>{decision.content}</Text>

                  {isSelected && (
                    <Text style={styles.selectedBadge}>✓ Choisi</Text>
                  )}
                </View>

                <View style={styles.infoRow}>
                  <Text style={styles.infoLabel}>Ressources</Text>
                  <Text style={styles.infoValue}>
                    {decision.resources_used === 0
                      ? "Gratuit"
                      : `${decision.resources_used / 1000}k`}
                  </Text>
                </View>

                <View style={styles.infoRow}>
                  <Text style={styles.infoLabel}>Score</Text>
                  <Text style={styles.scoreValue}>
                    {decision.score > 0 ? `+${decision.score}` : decision.score}
                  </Text>
                </View>

                {!canAfford && (
                  <Text style={styles.notEnough}>
                    Ressources insuffisantes
                  </Text>
                )}
              </TouchableOpacity>
            );
          })}
        </View>
      ))}
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
    marginBottom: 36,
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
    marginBottom: 24,
    color: "#6B7280",
    fontSize: 13,
    lineHeight: 18,
  },

  resourcesBox: {
    backgroundColor: "#151936",
    borderRadius: 18,
    padding: 16,
    marginBottom: 26,
  },

  resourcesTitle: {
    color: "#FFFFFF",
    fontSize: 16,
    fontWeight: "900",
    marginBottom: 10,
  },

  resourcesText: {
    color: "#FFFFFF",
    fontSize: 14,
    fontWeight: "700",
    marginBottom: 4,
  },

  section: {
    marginBottom: 26,
  },

  sectionTitle: {
    fontSize: 20,
    fontWeight: "900",
    color: "#151936",
    marginBottom: 12,
  },

  card: {
    backgroundColor: "#FFFFFF",
    borderRadius: 16,
    padding: 16,
    marginBottom: 12,
    borderWidth: 2,
    borderColor: "#FFFFFF",
    shadowColor: "#2525F2",
    shadowOpacity: 0.12,
    shadowRadius: 12,
    shadowOffset: {
      width: 0,
      height: 8,
    },
    elevation: 5,
  },

  cardSelected: {
    borderColor: "#2525F2",
    backgroundColor: "#F0EEFF",
  },

  cardDisabled: {
    opacity: 0.45,
  },

  cardHeader: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginBottom: 12,
  },

  cardTitle: {
    fontSize: 18,
    fontWeight: "900",
    color: "#151936",
  },

  selectedBadge: {
    backgroundColor: "#2525F2",
    color: "#FFFFFF",
    paddingHorizontal: 10,
    paddingVertical: 5,
    borderRadius: 12,
    fontSize: 11,
    fontWeight: "900",
  },

  infoRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    marginTop: 6,
  },

  infoLabel: {
    color: "#6B7280",
    fontSize: 13,
    fontWeight: "700",
  },

  infoValue: {
    color: "#151936",
    fontSize: 14,
    fontWeight: "900",
  },

  scoreValue: {
    color: "#2525F2",
    fontSize: 14,
    fontWeight: "900",
  },

  notEnough: {
    marginTop: 10,
    color: "#DC2626",
    fontWeight: "900",
    fontSize: 12,
  },
});