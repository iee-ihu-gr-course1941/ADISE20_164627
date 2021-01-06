# **README**

[University Project]
Εργασία ΑΔΙΣΕ 2020, Connect 4
Βασίλειος Αγοραστός, 164627

# Επεξήγηση database

![Image](https://i.imgur.com/xKUxxgU.jpeg)

TABLE players
pl_username: Όνομα χρήστη
pl_password: Κωδικός χρήστη
pl_color: Προεπιλεγμένο χρώμα χρήστη ('Y'(yellow) ή 'R'(red))
pl_last_action: Timestamp τελευταίας πράξης χρήστη

TABLE board
b_x: Συντεταγμένη Χ του πίνακα παιχνιδιού
b_y: Συντεταγμένη Y του πίνακα παιχνιδιού
b_piece_color: Χρώμα πιονιου στον πίνακα ('Y', 'R', NULL)
b_blocked: Αν ο χρήστης επιτρέπεται να βάλει πιόνι σε αυτη την τοποθεσία (O ή 1)

TABLE board_empty
Για αρχικοποίηση του TABLE board

TABLE game_status
g_status: (0=hasn't started yet, 1=started, 2=aborted)
g_turn: Σειρά παίκτη
g_result: (0=draw, 1=yellow, 2=red)
g_last_change: Timestamp τελευταίας αλλαγής στον πίνακα
g_logged_in: Πόσοι χρήστες είναι συνδεδεμένοι αυτή τη στιγμή

# Επεξήγηση λογικής

![Image](https://i.imgur.com/GAKaAOw.jpg)