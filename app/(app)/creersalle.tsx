import { Image } from 'expo-image';
import { router } from 'expo-router';
import { Alert, KeyboardAvoidingView, Platform, ScrollView, StyleSheet, Text, TextInput, TouchableOpacity, View } from 'react-native';

export default function CreerSalleScreen() {
    const handleSalle = () => {
        if (Platform.OS === 'web') {
            window.alert('Votre compte a été créé avec succès !');
            router.push('/(app)/nbjoueur');
        } else {
            Alert.alert(
            'Succès',
            'Votre compte a été créé avec succès !',
            [
                {
                text: 'OK',
                onPress: () => router.push('/(app)/nbjoueur'),
                },
            ]
            );
        }
      };
  return (
    <KeyboardAvoidingView style={styles.container} behavior={Platform.OS === 'ios' ? 'padding' : 'height'} keyboardVerticalOffset={80}>
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
                <Text style={styles.title}>Nom de la salle</Text>

                <Text style={styles.label}>Nom</Text>
                <View style={styles.inputContainer}>
                    <TextInput
                        style={styles.textInput}
                        placeholder="••••••"
                        placeholderTextColor="#6B7280"
                        secureTextEntry
                    />
                </View>

                <TouchableOpacity style={styles.button} onPress={handleSalle}>
                <Text style={styles.buttonText}>Entrer</Text>
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


});