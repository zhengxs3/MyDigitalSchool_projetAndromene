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

  const handleNb = () => {
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
            {[1, 2, 3, 4, 5, 6, 7, 8].map((num) => (
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

        {/* BUTTON */}
        <TouchableOpacity style={styles.button} onPress={handleNb}>
          <Text style={styles.buttonText}>Entrer</Text>
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

  buttonText: {
    color: '#FFFFFF',
    fontSize: 15,
    fontWeight: '700',
  },
});