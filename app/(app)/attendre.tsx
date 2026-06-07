import AsyncStorage from '@react-native-async-storage/async-storage';
import { router, useLocalSearchParams } from 'expo-router';
import { useEffect, useState } from 'react';
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

type Room = {
  id: number;
  code: string;
  max_players: number;
  created_by: number;
};

type Player = {
  id: number;
  user_id: number;
  name: string;
  role: string | null;
  status: string;
  isMe?: boolean;
  isHost?: boolean;
};

type Message = {
  id: number | string;
  user_id?: number;
  name: string;
  content: string;
  created?: string;
};

export default function Attendre() {
  const { roomId, partyId } = useLocalSearchParams();

  const [currentUser, setCurrentUser] = useState<any>(null);
  const [room, setRoom] = useState<Room | null>(null);
  const [players, setPlayers] = useState<Player[]>([]);
  const [messages, setMessages] = useState<Message[]>([]);
  const [messageText, setMessageText] = useState('');
  const [loading, setLoading] = useState(true);

  const showMessage = (title: string, message: string) => {
    if (Platform.OS === 'web') {
      window.alert(message);
    } else {
      Alert.alert(title, message);
    }
  };

  const loadUser = async () => {
    const userString = await AsyncStorage.getItem('user');

    if (!userString) {
      showMessage('Erreur', 'Utilisateur non connecté.');
      setLoading(false);
      return;
    }

    const user = JSON.parse(userString);
    setCurrentUser(user);
  };

  const fetchWaitingRoom = async () => {
    if (!currentUser) return;

    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/waiting-room/${roomId}?user_id=${currentUser.id}`
      );

      const data = await response.json();
      console.log('waiting room:', data);

      if (!response.ok) {
        showMessage('Erreur', data.message || 'Impossible de charger la salle.');
        return;
      }

      setRoom(data.room);
      setPlayers(data.players);
      setMessages(data.messages ?? []);

      if (data.started) {
        router.replace({
          pathname: '/(app)/role',
          params: {
            roomId,
            partyId,
          },
        });

        return;
      }
    } catch (error) {
      console.log(error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    loadUser();
  }, []);

  useEffect(() => {
    if (!roomId || !currentUser) return;

    fetchWaitingRoom();

    const interval = setInterval(() => {
      fetchWaitingRoom();
    }, 2000);

    return () => clearInterval(interval);
  }, [roomId, currentUser]);

  const codeSalle = room?.code ?? '';

  const me = players.find((player) => player.isMe);

  const isHost =
    room && currentUser
      ? Number(room.created_by) === Number(currentUser.id)
      : false;

  const isReady = me?.status === 'ready';

  const handleCopy = () => {
    if (!codeSalle) return;

    if (Platform.OS === 'web') {
      navigator.clipboard.writeText(codeSalle);
    }

    showMessage('Succès', 'Code copié.');
  };

  const handleSendMessage = async () => {
    if (!messageText.trim() || !currentUser || !partyId) return;

    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/send-message`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            party_id: partyId,
            user_id: currentUser.id,
            name: currentUser.pseudo ?? currentUser.name ?? 'Joueur',
            content: messageText.trim(),
          }),
        }
      );

      const data = await response.json();
      console.log('send message:', data);

      if (!response.ok) {
        showMessage('Erreur', data.message || 'Impossible d’envoyer le message.');
        return;
      }

      setMessages(data.messages ?? []);
      setMessageText('');
      fetchWaitingRoom();
    } catch (error) {
      console.log(error);
      showMessage('Erreur', 'Impossible de se connecter au serveur.');
    }
  };

  const handleReady = async () => {
    if (!currentUser || !partyId) return;

    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/ready-player`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            party_id: partyId,
            user_id: currentUser.id,
          }),
        }
      );

      const data = await response.json();
      console.log('ready player:', data);

      if (!response.ok) {
        showMessage('Erreur', data.message || 'Impossible de se préparer.');
        return;
      }

      fetchWaitingRoom();
    } catch (error) {
      console.log(error);
      showMessage('Erreur', 'Impossible de se connecter au serveur.');
    }
  };

  const handleUnready = async () => {
    if (!currentUser || !partyId) return;

    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/unready-player`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            party_id: partyId,
            user_id: currentUser.id,
          }),
        }
      );

      const data = await response.json();
      console.log('unready player:', data);

      if (!response.ok) {
        showMessage(
          'Erreur',
          data.message || 'Impossible d’annuler le statut prêt.'
        );
        return;
      }

      fetchWaitingRoom();
    } catch (error) {
      console.log(error);
      showMessage('Erreur', 'Impossible de se connecter au serveur.');
    }
  };

  const handleStart = async () => {
    if (!room) return;

    if (!isHost) {
      showMessage('Erreur', 'Seul l’hôte peut lancer la partie.');
      return;
    }

    const allReady = players.every(
      (player) => player.status === 'ready'
    );

    if (!allReady) {
      showMessage(
        'Erreur',
        'Tous les joueurs doivent être prêts.'
      );

      return;
    }

    try {
      const response = await fetch(
        `${process.env.EXPO_PUBLIC_BACKEND_URI}/rooms/start-game`,
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
          },
          body: JSON.stringify({
            party_id: partyId,
          }),
        }
      );

      const data = await response.json();

      if (!response.ok) {
        showMessage(
          'Erreur',
          data.message || 'Impossible de lancer la partie.'
        );

        return;
      }

      router.replace({
        pathname: '/(app)/role',
        params: {
          roomId,
          partyId,
        },
      });
    } catch (error) {
      console.log(error);

      showMessage(
        'Erreur',
        'Impossible de se connecter au serveur.'
      );
    }
  };

  if (loading) {
    return (
      <View style={styles.loadingContainer}>
        <Text style={styles.loadingText}>Chargement...</Text>
      </View>
    );
  }

  return (
    <KeyboardAvoidingView
      style={styles.container}
      behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
      keyboardVerticalOffset={80}
    >
      <ScrollView contentContainerStyle={styles.scrollContent}>
        <View style={styles.header}>
          <Text style={styles.menu}>☰</Text>
          <Text style={styles.logo}>BestNegotiator</Text>
          <View style={styles.avatar} />
        </View>

        <View style={styles.codeCard}>
          <View>
            <Text style={styles.codeLabel}>CODE DE LA SALLE</Text>
            <Text style={styles.codeText}>{codeSalle}</Text>
          </View>

          <TouchableOpacity style={styles.copyButton} onPress={handleCopy}>
            <Text style={styles.copyText}>Copier</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.playersHeader}>
          <Text style={styles.playersTitle}>
            Joueurs ({players.length}/{room?.max_players ?? 0})
          </Text>
          <Text style={styles.waitingBadge}>En attente...</Text>
        </View>

        <View style={styles.playersList}>
          {players.map((player) => (
            <View
              key={player.id}
              style={[
                styles.playerCard,
                player.isMe && styles.playerCardActive,
              ]}
            >
              <View style={styles.playerAvatar}>
                <Text style={styles.playerAvatarText}>
                  {player.name.charAt(0).toUpperCase()}
                </Text>
              </View>

              <View style={styles.playerInfo}>
                <Text style={styles.playerName}>
                  {player.name} {player.isMe ? '(Vous)' : ''}
                </Text>

                <Text style={styles.playerRole}>
                  {player.isHost
                    ? 'Hôte de la partie'
                    : player.role ?? 'En attente du rôle'}
                </Text>
              </View>

              <View
                style={[
                  styles.statusBadge,
                  player.status === 'ready'
                    ? styles.readyBadge
                    : styles.pendingBadge,
                ]}
              >
                <Text
                  style={[
                    styles.statusText,
                    player.status === 'ready'
                      ? styles.readyText
                      : styles.pendingText,
                  ]}
                >
                  {player.status === 'ready' ? '✓ Prêt' : '⌛ En attente'}
                </Text>
              </View>
            </View>
          ))}
        </View>

        <View style={styles.chatBox}>
          <View style={styles.chatHeader}>
            <Text style={styles.chatTitle}>CHAT DE GROUPE</Text>
            <Text>▢</Text>
          </View>

          <View style={styles.chatContent}>
            {messages.length === 0 ? (
              <Text style={styles.chatTyping}>
                Aucun message pour le moment.
              </Text>
            ) : (
              messages.map((message) => (
                <Text key={String(message.id)} style={styles.chatMessage}>
                  <Text style={styles.chatName}>{message.name} : </Text>
                  {message.content}
                </Text>
              ))
            )}
          </View>

          <View style={styles.messageInput}>
            <TextInput
              style={styles.input}
              placeholder="Message..."
              placeholderTextColor="#8A8A9E"
              value={messageText}
              onChangeText={setMessageText}
              onSubmitEditing={handleSendMessage}
            />

            <TouchableOpacity
              style={styles.sendButton}
              onPress={handleSendMessage}
            >
              <Text style={styles.sendText}>➤</Text>
            </TouchableOpacity>
          </View>
        </View>

        {isHost ? (
          <TouchableOpacity style={styles.startButton} onPress={handleStart}>
            <Text style={styles.startButtonText}>▶ Lancer la partie</Text>
          </TouchableOpacity>
        ) : !isReady ? (
          <TouchableOpacity style={styles.startButton} onPress={handleReady}>
            <Text style={styles.startButtonText}>✓ Je suis prêt</Text>
          </TouchableOpacity>
        ) : (
          <TouchableOpacity style={styles.readyInfo} onPress={handleUnready}>
            <Text style={styles.readyInfoText}>
              ✓ Vous êtes prêt
            </Text>
          </TouchableOpacity>
        )}
      </ScrollView>
    </KeyboardAvoidingView>
  );
}

const styles = StyleSheet.create({
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#FFFFFF',
  },

  loadingText: {
    fontSize: 16,
    fontWeight: '700',
    color: '#151936',
  },

  container: {
    flex: 1,
    backgroundColor: '#FFFFFF',
  },

  scrollContent: {
    paddingHorizontal: 18,
    paddingTop: 18,
    paddingBottom: 30,
  },

  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 26,
  },

  menu: {
    fontSize: 24,
    color: '#2525F2',
    fontWeight: '800',
  },

  logo: {
    fontSize: 26,
    fontWeight: '900',
    color: '#151936',
  },

  avatar: {
    width: 34,
    height: 34,
    borderRadius: 17,
    backgroundColor: '#151936',
  },

  codeCard: {
    borderWidth: 1,
    borderColor: '#D8D4E8',
    borderRadius: 12,
    padding: 14,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },

  codeLabel: {
    fontSize: 12,
    color: '#4B4B63',
    letterSpacing: 1,
  },

  codeText: {
    fontSize: 20,
    fontWeight: '900',
    color: '#0B00C7',
    marginTop: 4,
  },

  copyButton: {
    backgroundColor: '#2525F2',
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 8,
  },

  copyText: {
    color: '#FFFFFF',
    fontWeight: '800',
  },

  playersHeader: {
    marginTop: 22,
    marginBottom: 12,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },

  playersTitle: {
    fontSize: 21,
    fontWeight: '900',
    color: '#151936',
  },

  waitingBadge: {
    backgroundColor: '#E5E1FF',
    color: '#6B6488',
    paddingHorizontal: 10,
    paddingVertical: 6,
    borderRadius: 14,
    fontWeight: '600',
  },

  playersList: {
    gap: 10,
  },

  playerCard: {
    borderWidth: 1,
    borderColor: '#D8D4E8',
    borderRadius: 10,
    padding: 12,
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#FFFFFF',
  },

  playerCardActive: {
    borderColor: '#2525F2',
    backgroundColor: '#F6F4FF',
  },

  playerAvatar: {
    width: 42,
    height: 42,
    borderRadius: 21,
    backgroundColor: '#D8D4E8',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 12,
  },

  playerAvatarText: {
    fontSize: 18,
    fontWeight: '900',
    color: '#2525F2',
  },

  playerInfo: {
    flex: 1,
  },

  playerName: {
    fontSize: 15,
    fontWeight: '700',
    color: '#151936',
  },

  playerRole: {
    fontSize: 11,
    color: '#6B7280',
    marginTop: 2,
  },

  statusBadge: {
    paddingHorizontal: 8,
    paddingVertical: 6,
    borderRadius: 8,
  },

  readyBadge: {
    backgroundColor: '#D7F8DE',
  },

  pendingBadge: {
    backgroundColor: '#FFE8CC',
  },

  statusText: {
    fontSize: 12,
    fontWeight: '800',
  },

  readyText: {
    color: '#14883B',
  },

  pendingText: {
    color: '#D75A00',
  },

  chatBox: {
    marginTop: 36,
    borderWidth: 1,
    borderColor: '#D8D4E8',
    borderRadius: 10,
    overflow: 'hidden',
  },

  chatHeader: {
    backgroundColor: '#EDE9FF',
    padding: 8,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },

  chatTitle: {
    fontWeight: '900',
    color: '#4B4B63',
  },

  chatContent: {
    paddingHorizontal: 8,
    paddingVertical: 6,
    minHeight: 55,
  },

  chatMessage: {
    fontSize: 12,
    marginBottom: 4,
    color: '#151936',
  },

  chatName: {
    color: '#0B00C7',
    fontWeight: '900',
  },

  chatTyping: {
    fontSize: 11,
    color: '#8A8A9E',
    fontStyle: 'italic',
  },

  messageInput: {
    margin: 6,
    height: 32,
    borderWidth: 1,
    borderColor: '#D8D4E8',
    borderRadius: 6,
    flexDirection: 'row',
    alignItems: 'center',
    paddingLeft: 8,
  },

  input: {
    flex: 1,
    height: 30,
    fontSize: 12,
    color: '#151936',
    outlineStyle: 'none',
  } as any,

  sendButton: {
    width: 26,
    height: 26,
    borderRadius: 13,
    backgroundColor: '#0B00C7',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 3,
  },

  sendText: {
    color: '#FFFFFF',
    fontSize: 12,
  },

  startButton: {
    marginTop: 20,
    height: 48,
    backgroundColor: '#0B00C7',
    borderRadius: 9,
    justifyContent: 'center',
    alignItems: 'center',
  },

  startButtonText: {
    color: '#FFFFFF',
    fontWeight: '900',
    fontSize: 15,
  },

  readyInfo: {
    marginTop: 20,
    height: 48,
    borderRadius: 9,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#D7F8DE',
  },

  readyInfoText: {
    color: '#14883B',
    fontWeight: '900',
    fontSize: 15,
  },
});