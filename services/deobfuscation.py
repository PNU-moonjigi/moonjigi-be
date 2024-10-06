import os
import subprocess

def deobfuscate_php(filepath):
    absolute_filepath = os.path.abspath(filepath)
    cmd = ['php', 'index.php', '-f', absolute_filepath]
    try:
        result = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True, cwd='./PHPDeobfuscator')
        if result.returncode != 0:
            return f"비난독화 실패: {result.stderr}", 500
        return result.stdout  # 비난독화된 코드 반환
    except Exception as e:
        return f"오류 발생: {str(e)}", 500

def save_deobfuscated_code(code, original_filename):
    OUTPUT_FOLDER = 'outputs/'
    deobfuscated_filename = os.path.join(OUTPUT_FOLDER, original_filename)
    with open(deobfuscated_filename, 'w') as f:
        f.write(code)
    return deobfuscated_filename