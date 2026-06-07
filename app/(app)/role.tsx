import AsyncStorage from '@react-native-async-storage/async-storage';
import { router, useLocalSearchParams } from 'expo-router';
import { useEffect, useState } from 'react';
import {
    ActivityIndicator,
    Image,
    ImageSourcePropType,
    Platform,
    ScrollView,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
} from 'react-native';

import { ROLES } from '../../constants/roles';

type Player = {
  id: number;
  user_id: number;
  name: string;
  role: string | null;
  status: string;
  isMe?: boolean;
  isHost?: boolean;
};

type SecretRole = {
  id: string;
  name: string;
  image: ImageSourcePropType | null;
  objective: string;
  power: string;
};

export default function Role() {
  const { roomId, partyId } = useLocalSearchParams();

  const [currentUser, setCurrentUser] = useState<any>(null);
  const [players, setPlayers] = useState<Player[]>([]);
  const [myRole, setMyRole] = useState<SecretRole | null>(null);
  const [loading, setLoading] = useState(true);

  const loadUserAndRole = async () => {
    try {
        const userString = await AsyncStorage.getItem('user');

        if (!userString) {
            setLoading(false);
            return;
        }

        const user = JSON.parse(userString);
        setCurrentUser(user);

        const response = await fetch(
            `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/waiting-room/${roomId}?user_id=${user.id}`
        );

        const data = await response.json();

        if (!response.ok) {
            setLoading(false);
            return;
        }

        const roomPlayers: Player[] = data.players ?? [];
        setPlayers(roomPlayers);

        const myIndex = roomPlayers.findIndex(
        (player) => Number(player.user_id) === Number(user.id)
        );

        if (myIndex === -1) {
        setLoading(false);
        return;
        }

        const currentPlayer = roomPlayers[myIndex];

        // 如果数据库已经有 role，就直接用数据库里的 role
        if (currentPlayer.role) {
        const savedRole = ROLES.find((r) => r.id === currentPlayer.role);

        if (savedRole) {
            setMyRole(savedRole);
            return;
        }
        }

        // 如果数据库没有 role，才随机一个
        const randomIndex = Math.floor(Math.random() * ROLES.length);
        const role = ROLES[randomIndex];

        // 随机完马上保存到数据库
        await fetch(`${process.env.EXPO_PUBLIC_BACKEND_URI}/party-players/update-role`, {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    party_id: partyId,
    user_id: user.id,
    role: role.id,
  }),
});

        // 然后显示这个 role
        setMyRole(role);
    } catch (error) {
      console.log(error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadUserAndRole();
  }, []);

  const handleContinue = () => {
    router.replace({
      pathname: '/(app)/briefing',
      params: {
        roomId,
        partyId,
      },
    });
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <ActivityIndicator size="large" color="#2525F2" />
        <Text style={styles.loadingText}>Attribution du rôle...</Text>
      </View>
    );
  }

  if (!myRole) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={styles.errorTitle}>Rôle introuvable</Text>
        <Text style={styles.errorText}>
          Impossible d’attribuer votre rôle secret.
        </Text>
      </View>
    );
  }

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <View style={styles.header}>
        <Text style={styles.menu}>☰</Text>
        <Text style={styles.logo}>BestNegotiator</Text>
        <View style={styles.avatar} />
      </View>

      <Text style={styles.kicker}>MISSION CONFIDENTIELLE</Text>

      <Text style={styles.title}>Votre Rôle Secret</Text>

      <Text style={styles.subtitle}>
        Personne ne doit voir cet écran à part vous.
      </Text>

      <View style={styles.roleCard}>
        <Text style={styles.roleName}>{myRole.name}</Text>

        <View style={styles.imageBox}>
          {myRole.image ? (
            <Image source={myRole.image} style={styles.roleImage} />
          ) : (
            <Text style={styles.imagePlaceholder}>🎭</Text>
          )}
        </View>

        <View style={styles.separator} />

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>🎯 OBJECTIF</Text>

          <Text style={styles.infoText}>
            {myRole.objective}
          </Text>
        </View>

        <View style={styles.infoBlock}>
          <Text style={styles.infoTitle}>⚡ POUVOIR</Text>

          <Text style={styles.infoText}>
            {myRole.power}
          </Text>
        </View>
      </View>

      <TouchableOpacity
        style={styles.button}
        onPress={handleContinue}
      >
        <Text style={styles.buttonText}>
          Compris, je commence ›
        </Text>
      </TouchableOpacity>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  loadingContainer: {
    flex: 1,
    backgroundColor: '#F8F5FF',
    justifyContent: 'center',
    alignItems: 'center',
    padding: 24,
  },

  loadingText: {
    marginTop: 12,
    color: '#151936',
    fontWeight: '700',
    fontSize: 15,
  },

  errorTitle: {
    fontSize: 22,
    fontWeight: '900',
    color: '#151936',
  },

  errorText: {
    marginTop: 8,
    color: '#6B7280',
    textAlign: 'center',
    fontSize: 14,
  },

  container: {
    flexGrow: 1,
    backgroundColor: '#F8F5FF',
    paddingHorizontal: 20,
    paddingTop: Platform.OS === 'web' ? 24 : 44,
    paddingBottom: 30,
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 60,
  },

  menu: {
    fontSize: 22,
    color: '#2525F2',
    fontWeight: '900',
  },

  logo: {
    fontSize: 24,
    fontWeight: '900',
    color: '#0B00C7',
  },

  avatar: {
    width: 34,
    height: 34,
    borderRadius: 17,
    backgroundColor: '#151936',
  },

  kicker: {
    textAlign: 'center',
    color: '#2525F2',
    fontSize: 11,
    fontWeight: '900',
    letterSpacing: 1.2,
  },

  title: {
    textAlign: 'center',
    marginTop: 6,
    fontSize: 28,
    fontWeight: '900',
    color: '#151936',
  },

  subtitle: {
    textAlign: 'center',
    marginTop: 10,
    color: '#6B7280',
    fontSize: 13,
    lineHeight: 18,
  },

  roleCard: {
    marginTop: 30,
    backgroundColor: '#FFFFFF',
    borderRadius: 18,
    padding: 18,

    shadowColor: '#2525F2',
    shadowOpacity: 0.15,
    shadowRadius: 18,
    shadowOffset: {
      width: 0,
      height: 10,
    },

    elevation: 8,
  },

  imageBox: {
    height: 180,
    borderRadius: 14,
    backgroundColor: '#F1F1F8',
    justifyContent: 'center',
    alignItems: 'center',
    overflow: 'hidden',
  },

  roleImage: {
    width: '100%',
    height: '100%',
    resizeMode: 'cover',
  },

  imagePlaceholder: {
    fontSize: 48,
  },

  roleName: {
    marginBottom: 22,
    fontSize: 30,
    fontWeight: '900',
    textAlign: 'center',
    color: '#151936',
  },

  separator: {
    height: 1,
    backgroundColor: '#D8D4E8',
    marginVertical: 22,
  },

  infoBlock: {
    backgroundColor: '#F6F4FF',
    borderRadius: 14,
    padding: 15,
    marginBottom: 14,
  },

  infoTitle: {
    color: '#2525F2',
    fontSize: 12,
    fontWeight: '900',
    marginBottom: 7,
  },

  infoText: {
    color: '#151936',
    fontSize: 14,
    lineHeight: 21,
    fontWeight: '600',
  },

  button: {
    marginTop: 28,
    height: 54,
    borderRadius: 12,
    backgroundColor: '#2525F2',
    justifyContent: 'center',
    alignItems: 'center',

    shadowColor: '#2525F2',
    shadowOpacity: 0.25,
    shadowRadius: 12,
    shadowOffset: {
      width: 0,
      height: 8,
    },

    elevation: 6,
  },

  buttonText: {
    color: '#FFFFFF',
    fontWeight: '900',
    fontSize: 15,
  },
});