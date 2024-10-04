from flask import Flask, request
import os
import subprocess

app = Flask(__name__)

UPLOAD_FOLDER = 'uploads/'
OUTPUT_FOLDER = 'outputs/'
if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

if not os.path.exists(OUTPUT_FOLDER):
    os.makedirs(OUTPUT_FOLDER)

# 홈 엔드포인트 (테스트용)
@app.route('/')
def home():
    return 'This is Home!'

# 파일 업로드 및 비난독화 -> AST, OPCODE 추출 엔드포인트
@app.route('/upload', methods=['POST'])
def upload_file():
    if 'file' not in request.files:
        return "파일이 없음", 400
    file = request.files['file']
    if file.filename == '':
        return "파일 이름이 없음", 400
    if file and file.filename.endswith('.php'):
        filepath = os.path.join(UPLOAD_FOLDER, file.filename)
        file.save(filepath)
        
        # 비난독화 과정 호출
        deobfuscation_result = deobfuscate_php(filepath)
        if isinstance(deobfuscation_result, tuple):  # 오류가 발생한 경우
            return deobfuscation_result  # (메시지, 오류 코드)
        
        # 비난독화된 PHP 코드 저장
        deobfuscated_file = save_deobfuscated_code(deobfuscation_result, file.filename)

        # AST 및 Opcode 추출 호출
        ast_result = extract_ast(deobfuscated_file)
        opcode_result = extract_opcode(deobfuscated_file)
        
        if isinstance(ast_result, tuple) or isinstance(opcode_result, tuple):  # 오류가 발생한 경우
            return f"AST 또는 Opcode 추출 실패\nAST: {ast_result}\nOpcode: {opcode_result}", 500
        
        # 성공적으로 추출된 결과 반환
        return f"비난독화 및 AST/Opcode 추출 완료\n\nAST 결과: {ast_result}\n\nOpcode 결과: {opcode_result}"
    else:
        return "PHP 파일만 허용됨", 400

# 비난독화 과정
def deobfuscate_php(filepath):
    absolute_filepath = os.path.abspath(filepath)
    
    # PHPDeobfuscator CLI 실행
    cmd = ['php', 'index.php', '-f', absolute_filepath]
    try:
        result = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True, cwd='./PHPDeobfuscator')
        if result.returncode != 0:
            return f"비난독화 실패: {result.stderr}", 500
        return result.stdout  # 비난독화된 코드 반환
    except Exception as e:
        return f"오류 발생: {str(e)}", 500

# 비난독화된 코드를 저장하는 함수
def save_deobfuscated_code(code, original_filename):
    deobfuscated_filename = os.path.join(OUTPUT_FOLDER, original_filename)
    with open(deobfuscated_filename, 'w') as f:
        f.write(code)
    return deobfuscated_filename

# AST 추출 함수 (PHP-Parser 호출)
def extract_ast(filepath):
    output_dir = os.path.abspath(OUTPUT_FOLDER)
    try:
        # 절대 경로로 ast_parser.php 경로 설정
        ast_parser_path = os.path.abspath('ast_parser.php')

        # 명령어 구성: PHP 파일과 출력 디렉토리 전달
        cmd = ['php', ast_parser_path, filepath, output_dir]

        # 실행할 명령어 출력 (디버그)
        print(f"Running command: {' '.join(cmd)}")
        
        # subprocess로 PHP 스크립트 실행
        result = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        
        # 명령어의 출력 및 오류 확인
        print(f"Command output: {result.stdout}")
        print(f"Command error: {result.stderr}")
        
        if result.returncode != 0:
            return f"AST 추출 실패: {result.stderr}", 500
        return result.stdout
    except Exception as e:
        return f"오류 발생: {str(e)}", 500

# Opcode 추출 함수 (phpdbg 사용)
def extract_opcode(filepath):
    output_dir = os.path.abspath(OUTPUT_FOLDER)
    filename = os.path.basename(filepath).replace('.php', '_opcode.txt')
    opcode_filepath = os.path.join(output_dir, filename)
    
    try:
        # phpdbg를 사용해 Opcode 추출
        cmd = ['phpdbg', '-p', filepath]
        with open(opcode_filepath, 'w') as f:
            result = subprocess.run(cmd, stdout=f, stderr=subprocess.PIPE, text=True)
        
        if result.returncode != 0:
            return f"Opcode 추출 실패: {result.stderr}", 500
        return f"Opcode 추출 완료: {opcode_filepath}"
    except Exception as e:
        return f"오류 발생: {str(e)}", 500

if __name__ == '__main__':  
    app.run('0.0.0.0', port=5001, debug=True)