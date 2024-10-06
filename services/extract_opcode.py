import subprocess
import os

def extract_opcode(filepath):
    output_dir = os.path.abspath('outputs')
    filename = os.path.basename(filepath).replace('.php', '_opcode.txt')
    opcode_filepath = os.path.join(output_dir, filename)
    
    try:
        # phpdbg를 사용해 Opcode 추출
        cmd = ['phpdbg', '-p', filepath]  # phpdbg 명령에 '-p' 추가
        with open(opcode_filepath, 'w') as f:
            result = subprocess.run(cmd, stdout=f, stderr=subprocess.PIPE, text=True)
        
        if result.returncode != 0:
            return f"Opcode 추출 실패: {result.stderr}", 500
        return f"Opcode 추출 완료: {opcode_filepath}"
    except Exception as e:
        return f"오류 발생: {str(e)}", 500