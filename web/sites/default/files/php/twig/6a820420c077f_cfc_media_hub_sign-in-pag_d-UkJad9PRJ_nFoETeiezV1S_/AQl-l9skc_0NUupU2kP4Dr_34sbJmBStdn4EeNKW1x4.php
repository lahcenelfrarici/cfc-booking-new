<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:sign-in-page */
class __TwigTemplate_d422a9303470310e176f757ff753dd0f extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--sign-in-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:sign-in-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:sign-in-page"));
        yield "<div class=\"min-h-screen bg-[#FCFCFB] flex flex-col\" x-data=\"{ view: \x27signin\x27, showPassword: false }\">
  <div class=\"w-full max-w-[1440px] mx-auto px-12 h-20 flex items-center justify-between border-b border-neutral-100 bg-white\">
    <a href=\"";
        // line 3
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"flex items-center gap-2 text-[13px] text-neutral-500 hover:text-neutral-900 transition-colors\">
      ";
        // line 4
        yield from $this->load("cfc_media_hub:icon", 4)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-left", "size" => "w-4 h-4"]));
        // line 5
        yield "      Back
    </a>
    <span class=\"text-[13px] text-neutral-400\">
      <span x-show=\"view === \x27signin\x27\">Sign in to your account</span>
      <span x-show=\"view === \x27forgot\x27\" x-cloak>Reset your password</span>
    </span>
    <a href=\"";
        // line 11
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors\">Cancel</a>
  </div>

  <div class=\"flex-1 flex items-center justify-center px-12 py-16\">

    <div x-show=\"view === \x27signin\x27\" class=\"w-full max-w-[440px]\">
      <div class=\"flex justify-center mb-10\">
        <img src=\"";
        // line 18
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-16 w-auto\" />
      </div>

      <div class=\"bg-white rounded-3xl border border-neutral-200 shadow-[0_24px_60px_-20px_rgba(15,110,86,0.08)] p-10\">
        <h1 class=\"tracking-tight text-neutral-900 mb-1\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">Sign in</h1>
        <p class=\"text-neutral-500 mb-8 text-[14px]\">Access your CFC Media Hub account.</p>

        <form method=\"post\" action=\"";
        // line 25
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["login_action"] ?? null), "html", null, true);
        yield "\" class=\"space-y-4\">
          <input type=\"hidden\" name=\"form_id\" value=\"user_login_form\" />
          <input type=\"hidden\" name=\"form_build_id\" value=\"";
        // line 27
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["login_form_build_id"] ?? null), "html", null, true);
        yield "\" />

          <div>
            <label for=\"signin-name\" class=\"text-[12px] text-neutral-600 uppercase tracking-wide block mb-1.5 font-semibold\">Username or email</label>
            <input
              id=\"signin-name\" type=\"text\" name=\"name\" placeholder=\"you@media.org\" autocomplete=\"username\"
              class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#0F6E56] transition-colors\"
            />
          </div>

          <div>
            <div class=\"flex items-center justify-between mb-1.5\">
              <label for=\"signin-pass\" class=\"text-[12px] text-neutral-600 uppercase tracking-wide font-semibold\">Password</label>
              <button type=\"button\" x-on:click=\"view = \x27forgot\x27\" class=\"text-[12px] text-[#9F5434] hover:underline underline-offset-2 transition-colors font-medium\">
                Forgot password?
              </button>
            </div>
            <div class=\"relative\">
              <input
                id=\"signin-pass\" :type=\"showPassword ? \x27text\x27 : \x27password\x27\" name=\"pass\" placeholder=\"••••••••\" autocomplete=\"current-password\"
                class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 pr-11 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#0F6E56] transition-colors\"
              />
              <button type=\"button\" x-on:click=\"showPassword = !showPassword\" tabindex=\"-1\" class=\"absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 transition-colors\">
                <span x-show=\"!showPassword\">";
        // line 50
        yield from $this->load("cfc_media_hub:icon", 50)->unwrap()->yield(CoreExtension::toArray(["name" => "eye", "size" => "w-4 h-4"]));
        yield "</span>
                <span x-show=\"showPassword\" x-cloak>";
        // line 51
        yield from $this->load("cfc_media_hub:icon", 51)->unwrap()->yield(CoreExtension::toArray(["name" => "eye-off", "size" => "w-4 h-4"]));
        yield "</span>
              </button>
            </div>
          </div>

          <button type=\"submit\" name=\"op\" value=\"Log in\" class=\"w-full bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-3.5 rounded-2xl flex items-center justify-center gap-2 transition-colors mt-2 font-semibold text-[14px]\">
            Sign in
            ";
        // line 58
        yield from $this->load("cfc_media_hub:icon", 58)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4"]));
        // line 59
        yield "          </button>
        </form>

        <div class=\"mt-6 pt-6 border-t border-neutral-100 text-center text-[13px] text-neutral-500\">
          Don\x27t have an account?
          <a href=\"";
        // line 64
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["create_account_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[#9F5434] hover:underline underline-offset-2 transition-colors font-semibold\">Create account</a>
        </div>
      </div>

      <div class=\"mt-6 flex items-center justify-center gap-2 text-[12px] text-neutral-400\">
        ";
        // line 69
        yield from $this->load("cfc_media_hub:icon", 69)->unwrap()->yield(CoreExtension::toArray(["name" => "shield-check", "size" => "w-4 h-4 text-[#0F6E56]"]));
        // line 70
        yield "        Access is managed from the CFC Media Hub journalist registry.
      </div>
    </div>

    <div x-show=\"view === \x27forgot\x27\" x-cloak class=\"w-full max-w-[440px]\">
      <div class=\"flex justify-center mb-10\">
        <img src=\"";
        // line 76
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-16 w-auto\" />
      </div>

      <div class=\"bg-white rounded-3xl border border-neutral-200 shadow-[0_24px_60px_-20px_rgba(15,110,86,0.08)] p-10\">
        <button type=\"button\" x-on:click=\"view = \x27signin\x27\" class=\"flex items-center gap-1.5 text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors mb-7\">
          ";
        // line 81
        yield from $this->load("cfc_media_hub:icon", 81)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-left", "size" => "w-3.5 h-3.5"]));
        // line 82
        yield "          Back to sign in
        </button>

        <h1 class=\"tracking-tight text-neutral-900 mb-1\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">Reset password</h1>
        <p class=\"text-neutral-500 mb-8 leading-relaxed text-[14px]\">
          Enter the username or email address associated with your account. We\x27ll send you a link to reset your password.
        </p>

        <form method=\"post\" action=\"";
        // line 90
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["password_action"] ?? null), "html", null, true);
        yield "\" class=\"space-y-4\">
          <input type=\"hidden\" name=\"form_id\" value=\"user_pass\" />
          <input type=\"hidden\" name=\"form_build_id\" value=\"";
        // line 92
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["password_form_build_id"] ?? null), "html", null, true);
        yield "\" />

          <div>
            <label for=\"forgot-name\" class=\"text-[12px] text-neutral-600 uppercase tracking-wide block mb-1.5 font-semibold\">Username or email</label>
            <input
              id=\"forgot-name\" type=\"text\" name=\"name\" placeholder=\"you@media.org\" autocomplete=\"username\"
              class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#0F6E56] transition-colors\"
            />
          </div>

          <button type=\"submit\" name=\"op\" value=\"Submit\" class=\"w-full bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-3.5 rounded-2xl flex items-center justify-center gap-2 transition-colors font-semibold text-[14px]\">
            Send reset link
            ";
        // line 104
        yield from $this->load("cfc_media_hub:icon", 104)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4"]));
        // line 105
        yield "          </button>
        </form>
      </div>
    </div>

  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "logo_url", "login_action", "login_form_build_id", "create_account_url", "password_action", "password_form_build_id"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:sign-in-page";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  199 => 105,  197 => 104,  182 => 92,  177 => 90,  167 => 82,  165 => 81,  157 => 76,  149 => 70,  147 => 69,  139 => 64,  132 => 59,  130 => 58,  120 => 51,  116 => 50,  90 => 27,  85 => 25,  75 => 18,  65 => 11,  57 => 5,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:sign-in-page", "themes/custom/cfc_media_hub/components/sign-in-page/sign-in-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 4];
        static $filters = ["escape" => 3];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [0 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
