import { router, useLocalSearchParams } from 'expo-router';
import { useState } from 'react';
import {
  Alert,
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  StyleSheet,
  Text,
  TouchableOpacity,
  View,
} from 'react-native';

// Écran permettant au créateur de la salle de sélectionner le nombre maximum de joueurs.
export default function NbJoueur() {
  // Récupération de l'identifiant de la salle depuis les paramètres de navigation
  const { roomId } = useLocalSearchParams();

  // Nombre de joueurs actuellement sélectionné
  const [selected, setSelected] = useState(3);

  // État indiquant si une requête est en cours
  const [loading, setLoading] = useState(false);

  // Affiche un message adapté à la plateforme utilisée.
  const showMessage = (
    title: string,
    message: string,
    onPress?: () => void
  ) => {
    if (Platform.OS === 'web') {
      window.alert(message);
      onPress?.();
    } else {
      Alert.alert(title, message, [
        {
          text: 'OK',
          onPress,
        },
      ]);
    }
  };

  // Enregistre le nombre de joueurs sélectionné puis crée la partie associée à la salle.
  const handleNb = async () => {
    if (!roomId) {
      showMessage('Erreur', 'Salle introuvable.');
      return;
    }

    try {
      // Activation de l'état de chargement
      setLoading(true);

      // Requête de mise à jour du nombre maximum de joueurs
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/update-players/${roomId}`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            max_players: selected,
          }),
        }
      );

      const data = await response.json();

      if (!response.ok) {
        showMessage('Erreur', data.message || 'Erreur lors de la mise à jour.');
        return;
      }

      // Redirection vers la salle d'attente après création
      showMessage('Succès', 'Salle créée avec succès.', () => {
        router.push({
          pathname: '/(app)/attendre',
          params: {
            roomId,
            partyId: data.party.id,
          },
        });
      });
    } catch (error) {
      console.log(error);
      showMessage('Erreur', 'Impossible de se connecter au serveur.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
      keyboardVerticalOffset={80}
    >
      <ScrollView
        contentContainerStyle={styles.scrollContent}
        keyboardShouldPersistTaps="handled"
      >
        <View style={styles.card}>
          <Text style={styles.title}>Nombre de joueurs</Text>

          <View style={styles.playersGrid}>
            {[3, 4, 5, 6, 7, 8].map((num) => (
              <TouchableOpacity
                key={num}
                style={[
                  styles.playerBox,
                  selected === num && styles.playerBoxSelected,
                ]}
                onPress={() => setSelected(num)}
              >
                <Text
                  style={[
                    styles.playerText,
                    selected === num && styles.playerTextSelected,
                  ]}
                >
                  {num}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        <TouchableOpacity
          style={[styles.button, loading && styles.buttonDisabled]}
          onPress={handleNb}
          disabled={loading}
        >
          <Text style={styles.buttonText}>
            {loading ? 'Validation...' : 'Entrer'}
          </Text>
        </TouchableOpacity>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#FFFFFF',
  },

  scrollContent: {
    flexGrow: 1,
    paddingHorizontal: 20,
    paddingTop: 20,
    paddingBottom: 40,
  },

  card: {
    padding: 24,
  },

  title: {
    fontSize: 26,
    fontWeight: '800',
    color: '#151936',
    marginBottom: 30,
    textAlign: 'center',
  },

  playersGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    width: 200,
    alignSelf: 'center',
    justifyContent: 'space-between',
  },

  playerBox: {
    width: 90,
    height: 90,
    backgroundColor: '#DBD8E7',
    borderRadius: 10,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 12,
  },

  playerBoxSelected: {
    backgroundColor: '#2525F2',
  },

  playerText: {
    fontSize: 21,
    fontWeight: '700',
    color: '#151936',
  },

  playerTextSelected: {
    color: '#FFFFFF',
  },

  button: {
    width: '60%',
    height: 46,
    backgroundColor: '#2525F2',
    borderRadius: 10,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 28,
    alignSelf: 'center',
  },

  buttonDisabled: {
    opacity: 0.6,
  },

  buttonText: {
    color: '#FFFFFF',
    fontSize: 15,
    fontWeight: '700',
  },
});