import matplotlib.pyplot as plt
import numpy as np

# Funkcja do ręcznej regresji liniowej
def linear_regression_manual(X, y):
    # Obliczanie współczynników regresji: y = mx + b
    n = len(X)
    x_mean = np.mean(X)
    y_mean = np.mean(y)
    
    # Obliczanie m (nachylenie)
    numerator = sum((X[i] - x_mean) * (y[i] - y_mean) for i in range(n))
    denominator = sum((X[i] - x_mean) ** 2 for i in range(n))
    m = numerator / denominator if denominator != 0 else 0
    
    # Obliczanie b (przecięcie)
    b = y_mean - m * x_mean
    
    return m, b

# Liczba zadań w każdym sprincie
tasks_per_sprint = {
    "Sprint 1": 6,
    "Sprint 2": 5,
    "Sprint 3": 4,
    "Sprint 4": 4,
    "Sprint 5": 3
}

# Całkowita liczba zadań do wykonania na początku
total_tasks = sum(tasks_per_sprint.values())

# Obliczanie pozostałych zadań po każdym sprincie
remaining_tasks = [total_tasks]
completed = 0
for sprint in tasks_per_sprint.values():
    completed += sprint
    remaining_tasks.append(total_tasks - completed)

# Etykiety sprintów (w tym "Start")
sprint_labels = ["Start"] + list(tasks_per_sprint.keys())

# Tworzenie pierwszego wykresu
plt.figure(figsize=(10, 6))
bars = plt.bar(sprint_labels, remaining_tasks, color="skyblue", edgecolor="black")

# Dodanie wartości nad słupkami
for bar in bars:
    yval = bar.get_height()
    plt.text(bar.get_x() + bar.get_width()/2.0, yval + 0.5, int(yval), ha='center', va='bottom')

#plt.title("Liczba pozostałych zadań do wykonania w kolejnych sprintach")
plt.xlabel("Sprint")
plt.ylabel("Pozostałe zadania")
plt.grid(axis="y", linestyle="--", alpha=0.7)
plt.ylim(0, max(remaining_tasks) * 1.1)  # Górna krawędź +20%
#plt.tight_layout()
plt.savefig("wykres_pozostale_zadania.png")
plt.close()

# Przygotowanie danych do regresji liniowej
remaining_tasks_partial = remaining_tasks[:3]  # Bierzemy tylko pierwsze trzy sprinty
X_partial = np.array(range(len(remaining_tasks_partial)))
y_partial = np.array(remaining_tasks_partial)

# Ręczna regresja liniowa
m, b = linear_regression_manual(X_partial, y_partial)

# Predykcja dla pełnego zakresu sprintów
X_full = np.array(range(6))
y_pred_full = m * X_full + b

# Pełna lista sprintów do wyświetlenia
full_labels = ["Start", "Sprint 1", "Sprint 2", "Sprint 3", "Sprint 4", "Sprint 5"]

# Uzupełnienie danych: rzeczywiste dane + puste kolumny
extended_remaining_tasks = remaining_tasks_partial + [None] * (len(full_labels) - len(remaining_tasks_partial))

# Tworzenie drugiego wykresu
plt.figure(figsize=(10, 6))
# Słupki: dla rzeczywistych danych pokazujemy wartości, dla przyszłych pokazujemy puste
for i, val in enumerate(extended_remaining_tasks):
    if val is not None:
        plt.bar(full_labels[i], val, color="skyblue", edgecolor="black")
        plt.text(i, val + 0.5, int(val), ha='center', va='bottom')
    else:
        plt.bar(full_labels[i], 0, color="white", edgecolor="black", hatch="//")

# Linia regresji
plt.plot(full_labels, y_pred_full, color="red", linestyle="--", marker='o', label="Regresja liniowa")

#plt.title("Regresja liniowa i przewidywania na przyszłe sprinty")
plt.xlabel("Sprint")
plt.ylabel("Pozostałe zadania")
plt.legend()
plt.grid(axis="y", linestyle="--", alpha=0.7)
plt.ylim(0, max(remaining_tasks_partial + y_pred_full.tolist()) * 1.1)  # Górna krawędź +20%
#plt.tight_layout()
plt.savefig("wykres_regresja.png")
plt.close()

print("Wykresy zostały zapisane jako 'wykres_pozostale_zadania.png' i 'wykres_regresja.png'")
