Για την υλοποίηση της άσκησης, δημιούργησα το plugin local_project.
Για την εγκατάσταση του, πηγαίνουμε στο Site administration->plugins->Install plugins.
Ύστερα, στο url http://localhost/local/project/ μπορούμε να βρούμε την άσκηση.

index.php->
Ανοίγοντας τη, η σελίδα index.php μας δείχνει ένα απλό Registration Form, που ζητείται απο τον χρήστη να εισάγει τα δεδομένα Firstname, Lastname, Email , Country(select), και Mobile. Κατά την εγγραφή του νέου χρήστη , έχω ορίσει μερικά απλά validations, ώστε να βοηθήσει τον χρήστη στην εισαγώγή σωστών στοιχείων. (η φόρμα βρίσκεται στο αρχείο classes/registration_form.php) Κατα την ολοκλήρωση, δημιουργείται ο νέος χρήστης στη βάση δεδομένων mdl_registration_data, και
αν λειτουργούσε ο smtp mailing server, θα έστελνε email στο email του νέου χρήστη τα credentials του, ένα randomly generated password, και το link για login. Για testing purposes , έχω εισάγει κάτω απο το footer το table με όλους τους χρήστες, που μπορούμε να δούμε τα στοιχεία στη βάση δεδομένων.

login.php->
Την πρώτη φορά που κάνει ένα νέος χρήστης σύνδεση στη πλατφόρμα, του ζητείται να αλλάξει το default password του, σε ένα προσωπικό. Αυτό ελέγχεται με χρήση του status==-1 , καθώς και ενός session variable ύστερα, ώστε να γίνουν τα σωστά redirects.

passwordchange.php
Ο χρήστης εισάγει το email του, τον παλίο password και τον νέο , με ορισμένα πάλι validations (password>=10 , old!=new)
Στην επιτυχής αλλαγή, ενημερώνεται η βάση δεδομένων , και ο χρήστης πηγαίνει στο welcome page.

Σε όλες τις σελίδες υπάρχουν redirection checks, ώστε να κατευθύνεται ο χρήστης στη σωστή σελίδα. Για παράδειγμα, εάν κάποιος προσπαθήσει να επισκεφτεί το website.php ενώ δεν είναι logged in , ή δεν έχει αλλάξει το default password του, θα τον ανακατευθύνει στην αρχική σελίδα.