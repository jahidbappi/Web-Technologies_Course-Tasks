console.log("connected");

var display;
var justCalculated = false;
var operators = ["+", "-", "*", "/"];

function isOperator(char) {
  return operators.indexOf(char) !== -1;
}

function lastOperandHasDecimal(str) {
  var i = str.length - 1;
  while (i >= 0 && !isOperator(str.charAt(i))) {
    if (str.charAt(i) === ".") return true;
    i--;
  }
  return false;
}

function appendToDisplay(value) {
  if (!display) return;
  var current = display.value;
  if (current === "Error") {
    display.value = /^[0-9]$/.test(value) ? value : value === "-" ? value : "0" + value;
    justCalculated = false;
    return;
  }
  if (justCalculated && (value === "0" || value === "1" || value === "2" || value === "3" || value === "4" || value === "5" || value === "6" || value === "7" || value === "8" || value === "9" || value === ".")) {
    justCalculated = false;
    display.value = value === "." ? "0." : value;
    return;
  }
  if (isOperator(value)) {
    justCalculated = false;
  }
  if (current === "0" && value !== "." && value !== "+" && value !== "-" && value !== "*" && value !== "/" && value !== "(" && value !== ")") {
    display.value = value;
    return;
  }
  if (value === "(" || value === ")") {
    justCalculated = false;
    display.value = current + value;
    return;
  }
  var lastChar = current.charAt(current.length - 1);
  if (isOperator(value)) {
    if (isOperator(lastChar)) {
      if (value === "-" && (lastChar === "+" || lastChar === "*" || lastChar === "/")) {
        display.value = current + value;
      } else {
        display.value = current.slice(0, -1) + value;
      }
    } else {
      display.value = current + value;
    }
    return;
  }
  if (value === ".") {
    if (lastOperandHasDecimal(current)) return;
    if (lastChar === "" || isOperator(lastChar)) {
      display.value = current + "0.";
    } else {
      display.value = current + value;
    }
    return;
  }
  display.value = current + value;
}

function clearDisplay() {
  if (display) display.value = "0";
  justCalculated = false;
}

function appendPercent() {
  if (!display) return;
  var current = display.value;
  if (current === "Error") {
    display.value = "0*0.01";
    return;
  }
  var lastChar = current.charAt(current.length - 1);
  if (/[0-9.)]/.test(lastChar)) {
    display.value = current + "*0.01";
  } else {
    display.value = current + "0.01";
  }
}

function backspace() {
  if (!display) return;
  var current = display.value;
  if (current === "Error" || current === "0") {
    display.value = "0";
    return;
  }
  current = current.slice(0, -1);
  display.value = current.length === 0 ? "0" : current;
}

function formatResult(num) {
  if (num === Infinity || num === -Infinity || isNaN(num)) return null;
  if (Number.isInteger(num)) return String(num);
  var rounded = Math.round(num * 1e10) / 1e10;
  return String(rounded);
}

function calculate() {
  if (!display) return;
  var expr = display.value;
  if (!expr || expr === "0") return;
  expr = expr.replace(/\s/g, "");
  var lastChar = expr.charAt(expr.length - 1);
  if (isOperator(lastChar)) {
    expr = expr.slice(0, -1);
  }
  if (!expr) {
    display.value = "0";
    return;
  }
  try {
    var result = eval(expr);
    var formatted = formatResult(result);
    if (formatted === null) {
      display.value = "Error";
      return;
    }
    display.value = formatted;
    justCalculated = true;
  } catch (e) {
    display.value = "Error";
    justCalculated = false;
  }
}

function handleKeyDown(e) {
  var key = e.key;
  if (/^[0-9]$/.test(key)) {
    e.preventDefault();
    appendToDisplay(key);
    return;
  }
  if (key === "+" || key === "-" || key === "*" || key === "/") {
    e.preventDefault();
    appendToDisplay(key);
    return;
  }
  if (key === ".") {
    e.preventDefault();
    appendToDisplay(".");
    return;
  }
  if (key === "Enter" || key === "=") {
    e.preventDefault();
    calculate();
    return;
  }
  if (key === "(" || key === ")") {
    e.preventDefault();
    appendToDisplay(key);
    return;
  }
  if (key === "%") {
    e.preventDefault();
    appendPercent();
    return;
  }
  if (key === "Escape" || key === "c" || key === "C") {
    e.preventDefault();
    clearDisplay();
    return;
  }
  if (key === "Backspace" || key === "Delete") {
    e.preventDefault();
    var allSelected = display.selectionStart === 0 && display.selectionEnd === display.value.length;
    if (allSelected || display.value.length <= 1) {
      clearDisplay();
    } else {
      backspace();
    }
    return;
  }
}

function init() {
  display = document.getElementById("display");
  if (!display) return;
  document.addEventListener("keydown", handleKeyDown);
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}
