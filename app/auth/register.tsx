import { Image } from 'expo-image';
import { router } from 'expo-router';
import { KeyboardAvoidingView, Platform, StyleSheet, Text, TextInput, TouchableOpacity, View } from 'react-native';

export default function RegisterScreen() {
  return (
    <KeyboardAvoidingView style={styles.container} behavior={Platform.OS === 'ios' ? 'padding' : 'height'}>
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
            <Image
                source={require('@/assets/images/login1.png')}
                style={styles.inputIcon}
                contentFit="contain"
            />

            <TextInput
                style={styles.textInput}
                placeholder="Votre pseudonyme"
                placeholderTextColor="#6B7280"
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
            />
        </View>

        <TouchableOpacity style={styles.button}>
          <Text style={styles.buttonText}>Se connecter</Text>
        </TouchableOpacity>

        <Text style={styles.bottomText}>
          Pas de compte ?{' '}
          <Text
            style={styles.link}
            onPress={() => router.push('/auth/register')}
          >
            S’inscrire
          </Text>
        </Text>
      </View>
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

    textInput: {
        flex: 1,
        height: '100%',
        fontSize: 14,
    },

    container: {
        flex: 1,
        backgroundColor: '#fff',
        paddingHorizontal: 20,
        paddingTop: 10,
    },

    logoArea: {
        alignItems: 'center',
        marginBottom: 90,
    },

    logo: {
        width: 260,
        height: 80,
    },

    logo1: {
        width: 30,
        height: 30,
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

    buttonText: {
        color: '#fff',
        fontWeight: '700',
    },

    bottomText: {
        textAlign: 'center',
        marginTop: 28,
        color: '#666',
        fontSize: 15,
    },

    link: {
        color: '#2525F2',
        fontWeight: '700',
    },
});