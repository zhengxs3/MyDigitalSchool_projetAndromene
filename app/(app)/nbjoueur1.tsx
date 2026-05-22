import { router } from 'expo-router';
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

export default function NbJoueur() {
  const [selected, setSelected] = useState(1);

  const handleLogin = () => {
    if (Platform.OS === 'web') {
        window.alert('Votre compte a été créé avec succès !');
        router.push('/(app)/nbjoueur1');
    } else {
        Alert.alert(
        'Succès',
        'Votre compte a été créé avec succès !',
        [
            {
            text: 'OK',
            onPress: () => router.push('/(app)/nbjoueur1'),
            },
        ]
        );
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

        {/* CARD */}
        <View style={styles.card}>
          <Text style={styles.title}>Nombre de joueurs</Text>

          {/* GRID */}
          <View style={styles.playersGrid}>
            {['Pseudo 1', 'Pseudo 2', 'Pseudo 3', 'Pseudo 4',].map((pseudo) => (
              <Text key={pseudo} style={styles.playerText}>
                {pseudo}
              </Text>
            ))}
          </View>
        </View>

        {/* BUTTON */}
        <TouchableOpacity style={styles.buttonGray} onPress={handleLogin}>
          <Text style={styles.buttonText}>Actualiser</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.button} onPress={handleLogin}>
          <Text style={styles.buttonText}>Démarrer</Text>
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
    width: '100%',
    marginTop: 20,
    gap: 18,
  },

  playerBox: {
    width: 90,
    height: 90,

    backgroundColor: '#D8D4E8',
    borderRadius: 10,

    justifyContent: 'center',
    alignItems: 'center',

    marginBottom: 12,
  },

  playerBoxSelected: {
    backgroundColor: '#2525F2',
  },

  playerText: {
    fontSize: 22,
    fontWeight: '800',
    color: '#0B00C7',
  },

  playerTextSelected: {
    color: '#FFFFFF',
  },

  buttonGray: {
    width: '60%',
    height: 46,
    backgroundColor: '#B7B7BE',
    borderRadius: 10,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 120,
    alignSelf: 'center',
  },

  button: {
    width: '60%',
    height: 46,
    backgroundColor: '#2525F2',
    borderRadius: 10,

    justifyContent: 'center',
    alignItems: 'center',

    marginTop: 20,
    alignSelf: 'center',
  },

  buttonText: {
    color: '#FFFFFF',
    fontSize: 15,
    fontWeight: '700',
  },
});