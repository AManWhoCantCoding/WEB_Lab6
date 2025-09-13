# Queen5x5.py
from simpleai.search import CspProblem, backtrack
from simpleai.search import hill_climbing, simulated_annealing, genetic, SearchProblem
import random

# -------------------------
# Cấu hình CSP cho 5-Queens
# -------------------------
N = 5
variables = list(range(N))
domains = {var: list(range(N)) for var in variables}

def constraint(variables_pair, values_pair):
    v1, v2 = variables_pair
    x1, x2 = values_pair
    if x1 == x2:
        return False
    if abs(v1 - v2) == abs(x1 - x2):
        return False
    return True

constraints = []
for i in variables:
    for j in variables:
        if i < j:
            constraints.append(((i, j), constraint))

problem_csp = CspProblem(variables, domains, constraints)

# -------------------------
# Hàm in bàn cờ (dùng cho cả CSP và local search)
# -------------------------
def print_board(state):
    if isinstance(state, dict):  # CSP: {col: row}
        rows = [state[i] for i in sorted(state.keys())]
    else:  # Local search: tuple (row,...)
        rows = list(state)

    board = [["."] * N for _ in range(N)]
    for col, row in enumerate(rows):
        board[row][col] = "Q"
    for r in board:
        print(" ".join(r))
    print()

# -------------------------
# a) Backtracking
# -------------------------
print("a) Backtracking:")
solution_bt = backtrack(problem_csp)
print("Solution (backtrack):", solution_bt)
print_board(solution_bt)

# -------------------------
# b) Backtracking + AC3 (inference)
# -------------------------
print("\nb) Backtracking + AC3 (inference=True):")
solution_bt_ac3 = backtrack(problem_csp, inference=True)
print("Solution (backtrack + AC3):", solution_bt_ac3)
print_board(solution_bt_ac3)

# -------------------------
# Wrapper SearchProblem cho Local Search (Hill/SA/GA)
# -------------------------
class QueensProblem(SearchProblem):
    def __init__(self, n):
        self.n = n
        initial = tuple(random.randint(0, n - 1) for _ in range(n))
        super().__init__(initial_state=initial)

    def actions(self, state):
        acts = []
        for col in range(self.n):
            for row in range(self.n):
                if state[col] != row:
                    acts.append((col, row))
        return acts

    def result(self, state, action):
        col, row = action
        new = list(state)
        new[col] = row
        return tuple(new)

    def value(self, state):
        return -self.conflicts(state)

    def conflicts(self, state):
        c = 0
        for i in range(self.n):
            for j in range(i + 1, self.n):
                if state[i] == state[j]:
                    c += 1
                if abs(i - j) == abs(state[i] - state[j]):
                    c += 1
        return c

    # --- Genetic support ---
    def generate_random_state(self):
        return tuple(random.randint(0, self.n - 1) for _ in range(self.n))

    def random_state(self):
        return self.generate_random_state()

    def crossover(self, state1, state2):
        cut = random.randint(1, self.n - 1)
        return state1[:cut] + state2[cut:]

    def mutate(self, state):
        col = random.randrange(self.n)
        row = random.randrange(self.n)
        new = list(state)
        new[col] = row
        return tuple(new)

    def fitness(self, state):
        return self.value(state)

# -------------------------
# c) Hill Climbing
# -------------------------
print("\nc) Hill Climbing:")
qh = QueensProblem(N)
sol_hc = hill_climbing(qh, iterations_limit=1000)
print("Hill-climbing state:", sol_hc.state, "conflicts =", -qh.value(sol_hc.state))
print_board(sol_hc.state)

# -------------------------
# d) Simulated Annealing
# -------------------------
print("\nd) Simulated Annealing:")
qh2 = QueensProblem(N)
sol_sa = simulated_annealing(qh2, iterations_limit=2000)
print("Simulated Annealing state:", sol_sa.state, "conflicts =", -qh2.value(sol_sa.state))
print_board(sol_sa.state)

# -------------------------
# e) Genetic Algorithm
# -------------------------
print("\ne) Genetic Algorithm:")
qh3 = QueensProblem(N)
sol_ga = genetic(
    qh3,
    population_size=100,
    mutation_chance=0.3,
    iterations_limit=2000
)
print("Genetic state:", sol_ga.state, "conflicts =", -qh3.value(sol_ga.state))
print_board(sol_ga.state)

# -------------------------
# In lại kết quả Backtracking để so sánh
# -------------------------
print("\nBàn cờ Backtracking (exact):")
print_board(solution_bt)
