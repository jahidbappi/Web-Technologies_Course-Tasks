console.log("connected");

function countWords(text) {
  var trimmed = text.trim();
  if (trimmed.length === 0) return 0;
  return trimmed.split(/\s+/).length;
}

function reverseText(text) {
  return text.split("").reverse().join("");
}

function analyze() {
  var inputEl = document.getElementById("inputText");
  var resultEl = document.getElementById("result");
  var emptyStateEl = document.getElementById("emptyState");

  var text = inputEl ? inputEl.value : "";
  var trimmed = text.trim();
  var charCount = text.length;
  var wordCount = countWords(text);
  var reversed = reverseText(text);

  if (charCount === 0 || trimmed.length === 0) {
    if (resultEl) resultEl.style.display = "none";
    if (emptyStateEl) emptyStateEl.style.display = "block";
    return;
  }

  document.getElementById("charCount").innerHTML = charCount;
  document.getElementById("wordCount").innerHTML = wordCount;
  document.getElementById("reversedText").innerText = reversed;

  if (emptyStateEl) emptyStateEl.style.display = "none";
  if (resultEl) resultEl.style.display = "block";
}

function clearAll() {
  var inputEl = document.getElementById("inputText");
  var resultEl = document.getElementById("result");
  var emptyStateEl = document.getElementById("emptyState");

  if (inputEl) inputEl.value = "";
  if (resultEl) resultEl.style.display = "none";
  if (emptyStateEl) emptyStateEl.style.display = "block";

  var charEl = document.getElementById("charCount");
  var wordEl = document.getElementById("wordCount");
  var revEl = document.getElementById("reversedText");
  if (charEl) charEl.innerHTML = "0";
  if (wordEl) wordEl.innerHTML = "0";
  if (revEl) revEl.innerText = "";
}

function init() {
  var analyzeBtn = document.getElementById("analyzeBtn");
  var clearBtn = document.getElementById("clearBtn");
  if (analyzeBtn) analyzeBtn.addEventListener("click", analyze);
  if (clearBtn) clearBtn.addEventListener("click", clearAll);

  var inputEl = document.getElementById("inputText");
  if (inputEl) {
    inputEl.addEventListener("keydown", function (e) {
      if (e.key === "Enter" && (e.ctrlKey || e.metaKey)) {
        analyze();
      }
    });
  }
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}

