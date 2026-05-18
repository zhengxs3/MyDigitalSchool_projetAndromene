import { Image } from 'expo-image';
import { router } from 'expo-router';
import { StyleSheet, Text, TouchableOpacity, View } from 'react-native';

export default function HomeScreen() {
  return (
    <View style={styles.container}>
      <View style={styles.logoArea}>
        <Image
          source={require('@/assets/images/logo.png')}
          style={styles.logo}
          contentFit="contain"
        />
      </View>

      <View style={styles.buttonArea}>
        <TouchableOpacity style={styles.button} onPress={() => router.push('/auth/register')}>
          <Text style={styles.buttonText}>S'inscrire</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.button} onPress={() => router.push('/auth/login')}>
          <Text style={styles.buttonText}>Se connecter</Text>
        </TouchableOpacity>
      </View>

      <View style={styles.brandArea}>
        <Image
          source={require('@/assets/images/logo2.png')}
          style={styles.logo2}
          contentFit="contain"
        />
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingTop: 80,
    paddingBottom: 35,
  },

  logoArea: {
    alignItems: 'center',
  },

  logo: {
    width: 260,
    height: 260,
  },

  logo2: {
    width: 280,
    height: 120,
  },

  buttonArea: {
    width: '100%',
    alignItems: 'center',
    gap: 18,
  },

  button: {
    width: 250,
    height: 50,
    backgroundColor: '#2525F2',
    borderRadius: 13,
    alignItems: 'center',
    justifyContent: 'center',
  },

  buttonText: {
    color: '#fff',
    fontSize: 17,
    fontWeight: '700',
  },

  brandArea: {
    alignItems: 'center',
  },

  brandText: {
    fontSize: 24,
    fontWeight: '800',
    color: '#151936',
  },

  brandBlue: {
    color: '#2828ff',
  },
});