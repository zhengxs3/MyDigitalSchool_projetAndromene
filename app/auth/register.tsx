import { Image } from 'expo-image';
import { router } from 'expo-router';
import { useState } from 'react';
import {
  KeyboardAvoidingView,
  Platform,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  TouchableOpacity,
  View
} from 'react-native';

export default function RegisterScreen() {
  const [accepted, setAccepted] = useState(false);
  const [pseudo, setPseudo] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleRegister = async () => {
    if (!pseudo || !email || !password) {
      window.alert('Veuillez remplir tous les champs.');
      return;
    }

    if (!accepted) {
      window.alert("Vous devez accepter les conditions d'utilisation.");
      return;
    }

    const response = await fetch(`${process.env.EXPO_PUBLIC_BACKEND_URI}/users/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({
        pseudo,
        email,
        password,
      }),
    });

    const data = await response.json();

    if (response.ok) {
      window.alert('Votre compte a été créé avec succès !');
      router.push('/auth/login');
    } else {
      let message = data.message || 'Erreur inscription';

      if (data.errors?.email) {
        message = 'Cet email est déjà utilisé, veuillez en choisir un autre.';
      }

      if (data.errors?.pseudo) {
        message = 'Ce pseudo est déjà utilisé.';
      }
    
      window.alert(message);
    }

    // router.push('/auth/login');

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
          <Text style={styles.title}>Inscription</Text>

          <Text style={styles.subtitle}>
            Rejoignez l'élite des négociateurs et maîtrisez l'art de l'influence
            stratégique.
          </Text>

          <Text style={styles.label}>Pseudo</Text>
          <View style={styles.inputContainer}>
            <Image
              source={require('@/assets/images/login1.png')}
              style={styles.inputIcon}
              contentFit="contain"
            />
            <TextInput
              style={styles.textInput}
              placeholder="Votre pseudonyme"
              placeholderTextColor="#6B7280"
              value={pseudo}
              onChangeText={setPseudo}
            />
          </View>

          <Text style={styles.label}>Email</Text>
          <View style={styles.inputContainer}>
            <Image
              source={require('@/assets/images/email.png')}
              style={styles.inputIcon}
              contentFit="contain"
            />
            <TextInput
              style={styles.textInput}
              placeholder="nom@entreprise.fr"
              placeholderTextColor="#6B7280"
              value={email}
              onChangeText={setEmail}
            />
          </View>

          <Text style={styles.label}>Mot de passe</Text>
          <View style={styles.inputContainer}>
            <Image
              source={require('@/assets/images/login2.png')}
              style={styles.inputIcon}
              contentFit="contain"
            />
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
            style={styles.checkboxRow}
            onPress={() => setAccepted(!accepted)}
            activeOpacity={0.8}
          >
            <View style={[styles.checkbox, accepted && styles.checkboxActive]}>
              {accepted && <Text style={styles.checkMark}>✓</Text>}
            </View>

            <Text style={styles.terms}>
              J'accepte les conditions générales d'utilisation
            </Text>
          </TouchableOpacity>

          <TouchableOpacity style={styles.button} onPress={handleRegister}>
            <Text style={styles.buttonText}>S'inscrire</Text>
          </TouchableOpacity>

          <Text style={styles.bottomText}>
            Déjà un compte ?{' '}
            <Text style={styles.link} onPress={() => router.push('/auth/login')}>
              Se connecter
            </Text>
          </Text>
        </View>
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    paddingBottom: 40,
  },

  scrollContent: {
    flexGrow: 1,
    paddingHorizontal: 20,
    paddingTop: 10,
    paddingBottom: 40,
  },

  logoArea: {
    alignItems: 'center',
    marginBottom: 30,
  },

  logo: {
    width: 260,
    height: 80,
  },

  card: {
    width: '100%',
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 22,

    shadowColor: '#000',
    shadowOpacity: 0.08,
    shadowRadius: 18,
    shadowOffset: { width: 0, height: 8 },
    elevation: 5,
  },

  title: {
    fontSize: 29,
    fontWeight: '800',
    color: '#0B00C7',
    marginBottom: 10,
  },

  subtitle: {
    fontSize: 13,
    color: '#454557',
    lineHeight: 18,
    marginBottom: 35,
    fontWeight: '600',
  },

  label: {
    fontSize: 13,
    color: '#454557',
    marginBottom: 6,
    fontWeight: '600',
  },

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

  textInput: {
    flex: 1,
    height: '100%',
    fontSize: 14,
  },

  checkboxRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginTop: 2,
    marginBottom: 22,
  },

  checkbox: {
    width: 16,
    height: 16,
    borderWidth: 1,
    borderColor: '#C9C7D8',
    borderRadius: 3,
    marginRight: 8,
    alignItems: 'center',
    justifyContent: 'center',
  },

  checkboxActive: {
    backgroundColor: '#2525F2',
    borderColor: '#2525F2',
  },

  checkMark: {
    color: '#fff',
    fontSize: 11,
    fontWeight: '800',
  },

  terms: {
    fontSize: 12,
    color: '#404564',
  },

  button: {
    width: '100%',
    height: 42,
    backgroundColor: '#2525F2',
    borderRadius: 8,
    alignItems: 'center',
    justifyContent: 'center',
  },

  buttonText: {
    color: '#fff',
    fontWeight: '700',
  },

  bottomText: {
    textAlign: 'center',
    marginTop: 30,
    color: '#666',
    fontSize: 13,
  },

  link: {
    color: '#2525F2',
    fontWeight: '700',
  },
});