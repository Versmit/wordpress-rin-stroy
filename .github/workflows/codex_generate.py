import openai
import os

openai.api_key = os.getenv("OPENAI_API_KEY")

# Тут пишешь конкретную задачу для Codex
prompt = """
Создай файл test-codex.txt с текстом 'Автоматический файл от Codex!'
"""

response = openai.Completion.create(
    engine="code-davinci-002",
    prompt=prompt,
    max_tokens=1000,
    temperature=0
)

# Сохраняем ответ в новый файл
with open("test-codex.txt", "w", encoding="utf-8") as f:
    f.write(response.choices[0].text.strip())
