import re

path = r'c:\Herd\twoclicks-v2\resources\views\system\twoclicks\layouts\app.blade.php'

with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Replace inner content of kt_app_content with @yield('content')
content = re.sub(
    r'(<div id="kt_app_content" class="app-content flex-column-fluid">).+?(\s*</div>\s*\n\s*<!--end::Content-->)',
    lambda m: m.group(1) + "\n                                @yield('content')\n                            " + m.group(2).lstrip(),
    content,
    flags=re.DOTALL
)

# 2. Update footer: replace copyright + remove menu
content = re.sub(
    r'<span class="text-muted fw-semibold me-1">2025&copy;</span>.*?<!--end::Menu-->',
    """<span class="text-muted fw-semibold me-1">2012 &bull; {{ date('Y') }}</span>
                                <a href="https://twoclicks.com.br" target="_blank"
                                    class="text-gray-800 text-hover-primary">TwoClicks</a>
                            </div>
                            <!--end::Copyright-->""",
    content,
    flags=re.DOTALL
)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)

with open(path, 'r', encoding='utf-8') as f:
    result = f.read()

print("yield:", "@yield('content')" in result)
print("twoclicks:", "twoclicks.com.br" in result)
print("keenthemes removed:", "keenthemes.com" not in result)
print("menu removed:", "menu-gray-600" not in result)
