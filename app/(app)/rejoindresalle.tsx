import { Image } from 'expo-image';
import { router } from 'expo-router';
import { useState } from 'react';

import AsyncStorage from '@react-native-async-storage/async-storage';

import {
    Alert,
    KeyboardAvoidingView,
    Platform,
    ScrollView,
    StyleSheet,
    Text,
    TextInput,
    TouchableOpacity,
    View,
} from 'react-native';

export default function RejoindreSalleScreen() {
  const [code, setCode] = useState('');
  const [loading, setLoading] = useState(false);

  const showMessage = (title: string, message: string) => {
    if (Platform.OS === 'web') {
      window.alert(message);
    } else {
      Alert.alert(title, message);
    }
  };

  const handleSalle = async () => {
    if (!code.trim()) {
      showMessage('Erreur', 'Veuillez entrer le code de la salle.');
      return;
    }

    try {
      setLoading(true);

      const userString = await AsyncStorage.getItem('user');

      if (!userString) {
        showMessage('Erreur', 'Utilisateur non connecté.');
        return;
      }

      const user = JSON.parse(userString);

      console.log('USER = ', user);

      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/join-by-code`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            code: code.trim(),
            user_id: user.id,
          }),
        }
      );

      const data = await response.json();

      console.log('JOIN ROOM = ', data);

      if (!response.ok) {
        showMessage(
          'Erreur',
          data.message || 'Impossible de rejoindre la salle.'
        );
        return;
      }

      router.push({
        pathname: '/(app)/attendre',
        params: {
          roomId: data.room.id,
          partyId: data.party.id,
        },
      });
    } catch (error) {
      console.log('ERROR = ', error);
      console.log('BACKEND = ', process.env.EXPO_PUBLIC_BACKEND_URI);

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
        <View style={styles.logoArea}>
          <Image
            source={require('@/assets/images/logo3.png')}
            style={styles.logo}
            contentFit="contain"
          />
        </View>

        <View style={styles.card}>
          <Text style={styles.title}>Code de salle</Text>

          <Text style={styles.label}>Code de 6 chiffres</Text>

          <View style={styles.inputContainer}>
            <Image
              source={require('@/assets/images/login2.png')}
              style={styles.inputIcon}
              contentFit="contain"
            />

            <TextInput
              style={styles.textInput}
              placeholder="••••••"
              placeholderTextColor="#6B7280"
              value={code}
              onChangeText={setCode}
              keyboardType="numeric"
              maxLength={6}
            />
          </View>

          <TouchableOpacity
            style={[styles.button, loading && styles.buttonDisabled]}
            onPress={handleSalle}
            disabled={loading}
          >
            <Text style={styles.buttonText}>
              {loading ? 'Connexion...' : 'Entrer'}
            </Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  inputContainer: {
    width: '100%',
    height: 50,
    borderWidth: 1,
    borderColor: '#D8D4E8',
    borderRadius: 6,
    backgroundColor: '#FBF9FF',
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 10,
    marginBottom: 18,
  },

  inputIcon: {
    width: 18,
    height: 18,
    marginRight: 10,
  },

  scrollContent: {
    flexGrow: 1,
    paddingHorizontal: 20,
    paddingTop: 10,
    paddingBottom: 40,
  },

  textInput: {
    flex: 1,
    height: '100%',
    fontSize: 14,
    color: '#151936',
  },

  container: {
    flex: 1,
    backgroundColor: '#fff',
  },

  logoArea: {
    alignItems: 'center',
    marginBottom: 90,
  },

  logo: {
    width: 260,
    height: 80,
  },

  card: {
    width: '100%',
    backgroundColor: '#fff',
    borderRadius: 12,
    padding: 20,
    shadowColor: '#000',
    shadowOpacity: 0.08,
    shadowRadius: 15,
    shadowOffset: { width: 0, height: 6 },
    elevation: 4,
  },

  title: {
    fontSize: 29,
    fontWeight: '800',
    color: '#0B00C7',
    marginBottom: 30,
  },

  label: {
    fontSize: 13,
    color: '#151936',
    marginBottom: 6,
    fontWeight: '600',
  },

  button: {
    width: '100%',
    height: 42,
    backgroundColor: '#2525F2',
    borderRadius: 8,
    alignItems: 'center',
    justifyContent: 'center',
    marginTop: 4,
  },

  buttonDisabled: {
    opacity: 0.6,
  },

  buttonText: {
    color: '#fff',
    fontWeight: '700',
  },
});