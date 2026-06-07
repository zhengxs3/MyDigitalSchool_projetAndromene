import AsyncStorage from '@react-native-async-storage/async-storage';
import { Image } from 'expo-image';
import { router } from 'expo-router';
import { useState } from 'react';

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

export default function LoginScreen() {
  const [pseudo, setPseudo] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/users/login`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            pseudo,
            password,
          }),
        }
      );

      const data = await response.json();

      if (response.ok) {
        // 保存用户
        await AsyncStorage.setItem(
          'user',
          JSON.stringify(data.user)
        );

        console.log('USER SAVED = ', data.user);

        if (Platform.OS === 'web') {
          window.alert(`Connexion réussie ! Bienvenue ${pseudo}`);
          router.push('/(app)/choixsalle');
        } else {
          Alert.alert('Succès', 'Connexion réussie !', [
            {
              text: 'OK',
              onPress: () => router.push('/(app)/choixsalle'),
            },
          ]);
        }
      } else {
        if (Platform.OS === 'web') {
          window.alert(
            data.message || 'Pseudo ou mot de passe incorrect.'
          );
        } else {
          Alert.alert(
            'Erreur',
            data.message || 'Pseudo ou mot de passe incorrect.'
          );
        }
      }
    } catch (error) {
      console.log(error);

      if (Platform.OS === 'web') {
        window.alert('Erreur serveur.');
      } else {
        Alert.alert('Erreur', 'Erreur serveur.');
      }
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
          <Text style={styles.title}>Se connecter</Text>

          <Text style={styles.label}>Pseudo</Text>

          <View style={styles.inputContainer}>
            <TextInput
              style={styles.textInput}
              placeholder="Votre pseudonyme"
              placeholderTextColor="#6B7280"
              value={pseudo}
              onChangeText={setPseudo}
            />
          </View>

          <Text style={styles.label}>Mot de passe</Text>

          <View style={styles.inputContainer}>
            <TextInput
              style={styles.textInput}
              placeholder="••••••••"
              placeholderTextColor="#6B7280"
              secureTextEntry
              value={password}
              onChangeText={setPassword}
            />
          </View>

          <TouchableOpacity
            style={styles.button}
            onPress={handleLogin}
          >
            <Text style={styles.buttonText}>
              Se connecter
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

  buttonText: {
    color: '#fff',
    fontWeight: '700',
  },
});