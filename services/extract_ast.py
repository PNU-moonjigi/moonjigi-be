import subprocess
import os

def extract_ast(filepath):
    output_dir = os.path.abspath('outputs')
    try:
        ast_parser_path = os.path.abspath('ast_parser.php')
        cmd = ['php', ast_parser_path, filepath, output_dir]
        
        # 명령어 실행
        result = subprocess.run(cmd, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        
        if result.returncode != 0:
            return f"AST 추출 실패: {result.stderr}", 500
        return result.stdout
    except Exception as e:
        return f"오류 발생: {str(e)}", 500