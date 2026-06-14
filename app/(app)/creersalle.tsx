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

// Écran permettant à l'utilisateur de créer une nouvelle salle.
export default function CreerSalleScreen() {
  // Nom de la salle saisi par l'utilisateur
  const [roomName, setRoomName] = useState('');

  // État indiquant si la création est en cours
  const [loading, setLoading] = useState(false);

  // Affiche un message d'alerte adapté à la plateforme.
  const showMessage = (
    title: string,
    message: string
  ) => {
    if (Platform.OS === 'web') {
      window.alert(message);
    } else {
      Alert.alert(title, message);
    }
  };

  // Crée une nouvelle salle via l'API.
  const handleSalle = async () => {
    if (!roomName.trim()) {
      showMessage(
        'Erreur',
        'Veuillez entrer le nom de la salle.'
      );
      return;
    }

    try {
      setLoading(true); // Activation de l'état de chargement

      // Récupération de l'utilisateur connecté depuis le stockage local
      const userString = await AsyncStorage.getItem('user');

      // Vérification de la connexion utilisateur
      if (!userString) {
        showMessage('Erreur', 'Utilisateur non connecté.');
        return;
      }

      // Conversion des données utilisateur en objet JavaScript
      const user = JSON.parse(userString);

      console.log('USER = ', user);

      // Envoi de la requête de création de salle au backend
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/add`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: roomName.trim(),
            created_by: user.id,
          }),
        }
      );

      const data = await response.json();

      if (!response.ok) {
        showMessage(
          'Erreur',
          data.message || 'Erreur lors de la création.'
        );
        return;
      }

      // Redirection vers l'écran de sélection du nombre de joueurs
      router.push({
        pathname: '/(app)/nbjoueur',
        params: {
          roomId: data.room.id,
        },
      });
    } catch (error) {
      console.log('ERROR = ', error);

      showMessage(
        'Erreur',
        'Impossible de se connecter au serveur.'
      );
    } finally {
      setLoading(false); // Désactivation de l'état de chargement
    }
  };

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={
        Platform.OS === 'ios'
          ? 'padding'
          : 'height'
      }
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
          <Text style={styles.title}>
            Nom de la salle
          </Text>

          <Text style={styles.label}>Nom</Text>

          <View style={styles.inputContainer}>
            <TextInput
              style={styles.textInput}
              placeholder="Nom de la salle"
              placeholderTextColor="#6B7280"
              value={roomName}
              onChangeText={setRoomName}
            />
          </View>

          <TouchableOpacity
            style={[
              styles.button,
              loading && styles.buttonDisabled,
            ]}
            onPress={handleSalle}
            disabled={loading}
          >
            <Text style={styles.buttonText}>
              {loading
                ? 'Création...'
                : 'Entrer'}
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

  scrollContent: {
    flexGrow: 1,
    paddingHorizontal: 20,
    paddingTop: 10,
    paddingBottom: 40,
  },

  textInput: {
    paddingLeft: 15,
    flex: 1,
    height: '100%',
    fontSize: 14,
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