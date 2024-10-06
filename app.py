from flask import Flask
from routes.file_upload import file_upload_bp

app = Flask(__name__)

# 블루프린트 등록
app.register_blueprint(file_upload_bp)

# 홈 엔드포인트
@app.route('/')
def home():
    return 'This is Home!'

if __name__ == '__main__':
    app.run('0.0.0.0', port=5001, debug=False)