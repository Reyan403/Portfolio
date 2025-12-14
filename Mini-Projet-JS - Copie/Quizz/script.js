// Sélection des éléments du DOM
const startBtn = document.querySelector(".start-btn");
const popupInfo = document.querySelector(".popup-info");
const exitBtn = document.querySelector(".exit-btn");
const main = document.querySelector(".main");
const continueBtn = document.querySelector(".continue-btn");
const quizSection = document.querySelector(".quiz-section");
const quizBox = document.querySelector(".quiz-box");
const resultBox = document.querySelector(".result-box");
const tryAgainBtn = document.querySelector(".tryAgain-btn");
const goHomeBtn = document.querySelector(".goHome-btn");

// Quand on clique sur "Start", on affiche la popup d'information
startBtn.onclick = () => {
  popupInfo.classList.add("active");
}

// Quand on clique sur "Exit", on ferme la popup
exitBtn.onclick = () => {
  popupInfo.classList.remove("active");
}

// Quand on clique sur "Continue", on démarre le quiz
continueBtn.onclick = () => {
  quizSection.classList.add("active");
  popupInfo.classList.remove("active");
  quizBox.classList.add("active");

  // Afficher la première question
  showQuestions(0);
  questionCounter(1);
  headerScore();
}

// Quand on clique sur "Try Again", on redémarre le quiz depuis le début
tryAgainBtn.onclick = () => {
  quizBox.classList.add("active");
  nextBtn.classList.remove("active");
  resultBox.classList.remove("active");

  // Réinitialiser les compteurs
  questionCount = 0;
  questionNumb = 1;
  userScore = 0;

  // Afficher la première question
  showQuestions(questionCount);
  questionCounter(questionNumb);
  headerScore();
}

// Retour à l'accueil depuis la fin du quiz
goHomeBtn.onclick = () => {
  quizSection.classList.remove("active");
  nextBtn.classList.remove("active");
  resultBox.classList.remove("active");

  // Réinitialiser les compteurs
  questionCount = 0;
  questionNumb = 1;
  userScore = 0;

  showQuestions(questionCount);
  questionCounter(questionNumb);
  headerScore();
}

// Initialisation des variables de contrôle
let questionCount = 0;
let questionNumb = 1;
let userScore = 0;

const nextBtn = document.querySelector(".next-btn");

// Quand on clique sur "Next"
nextBtn.onclick = () => {
  if (questionCount < questions.length - 1) {
    questionCount++; // passer à la question suivante
    showQuestions(questionCount);

    questionNumb++;
    questionCounter(questionNumb);

    nextBtn.classList.remove("active");
  } else {
    // Si toutes les questions ont été posées, afficher le résultat
    showResultBox();
  }
}

const optionList = document.querySelector(".option-list");

// Fonction pour afficher une question et ses options
function showQuestions(index) {
  const questionText = document.querySelector(".question-text");
  questionText.textContent = `${questions[index].num}. ${questions[index].question}`;

  // Génération dynamique des options de réponse
  let optionTag = `<div class="option"><span>${questions[index].options[0]}</span></div>
  <div class="option"><span>${questions[index].options[1]}</span></div>
  <div class="option"><span>${questions[index].options[2]}</span></div>
  <div class="option"><span>${questions[index].options[3]}</span></div>`;

  optionList.innerHTML = optionTag;

  // Ajouter un événement de clic sur chaque option
  const option = document.querySelectorAll(".option");
  for (let i = 0; i < option.length; i++) {
    option[i].setAttribute("onclick", "optionSelected(this)");
  }
}

// Fonction exécutée lorsqu'une option est sélectionnée
function optionSelected(answer) {
  let userAnswer = answer.textContent;
  let correctAnswer = questions[questionCount].answer;
  let allOptions = optionList.children.length;
  
  if (userAnswer === correctAnswer) {
    // Bonne réponse
    answer.classList.add("correct");
    userScore += 1;
    headerScore();
  } else {
    // Mauvaise réponse
    answer.classList.add("wrong");

    // Affiche la bonne réponse
    for (let i = 0; i < allOptions; i++) {
      if (optionList.children[i].textContent === correctAnswer) {
        optionList.children[i].setAttribute("class", "option correct");
      }
    }
  }

  // Désactiver toutes les options après la sélection
  for (let i = 0; i < allOptions; i++) {
    optionList.children[i].classList.add("disabled");
  }

  // Afficher le bouton "Next"
  nextBtn.classList.add("active");
}

// Met à jour le compteur de questions affiché dans l'en-tête
function questionCounter(index) {
  const questionTotal = document.querySelector(".question-total");
  questionTotal.textContent = `${index} sur ${questions.length} Questions`;
}

// Met à jour le score affiché dans l'en-tête
function headerScore() {
  const headerScoreText = document.querySelector(".header-score");
  headerScoreText.textContent = `Score: ${userScore} / ${questions.length}`;
}

// Affiche la boîte de résultat à la fin du quiz
function showResultBox(){
  quizBox.classList.remove("active");
  resultBox.classList.add("active");

  const scoreText = document.querySelector(".score-text");
  scoreText.textContent = `Votre score ${userScore} est de ${questions.length}`;

  // Animation de progression circulaire
  const circularProgress = document.querySelector(".circular-progress");
  const progressValue = document.querySelector(".progress-value");
  let progressStartValue = -1;
  let progressEndValue = (userScore / questions.length) * 100;
  let speed = 20;

  let progress = setInterval(() => {
    progressStartValue++;

    progressValue.textContent = `${progressStartValue}%`;
    circularProgress.style.background = `conic-gradient(#c40094 ${progressStartValue * 3.6}deg, rgba(255, 255, 255, .1) 0deg)`;

    if (progressStartValue === progressEndValue) {
      clearInterval(progress);
    }
  }, speed);
}
