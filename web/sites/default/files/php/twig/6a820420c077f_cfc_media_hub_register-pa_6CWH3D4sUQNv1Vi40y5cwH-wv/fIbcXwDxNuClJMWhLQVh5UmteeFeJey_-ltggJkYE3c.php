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

/* cfc_media_hub:register-page */
class __TwigTemplate_9b77c7b855db044bad5cede132faa127 extends Template
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
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--register-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:register-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:register-page"));
        yield "<div class=\"min-h-screen bg-[#FCFCFB] flex flex-col\" x-data=\"{ chosen: false }\">
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
    ";
        // line 7
        yield from $this->load("cfc_media_hub:journey-steps", 7)->unwrap()->yield(CoreExtension::toArray(["active" => [1]]));
        // line 8
        yield "    <a href=\"";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors\">Cancel</a>
  </div>

  <div x-show=\"!chosen\" class=\"flex-1 px-12 py-16\">
    <div class=\"max-w-[860px] mx-auto\">
      <div class=\"text-center mb-14\">
        <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#0F6E56] font-semibold mb-4\">Step 1 · Create an account</div>
        <h1 class=\"tracking-tight text-neutral-900\" style=\"font-size: 56px; font-weight: 600; line-height: 1.05; letter-spacing: -0.03em;\">
          Who are you?
        </h1>
        <p class=\"mt-4 text-neutral-500 max-w-[480px] mx-auto leading-relaxed text-[16px]\">
          Select your profile type to get started. Access conditions differ depending on your status.
        </p>
      </div>

      <div class=\"grid grid-cols-2 gap-6\">
        <div
          class=\"rounded-3xl p-9 border cursor-pointer group transition-all border-[#9F5434]/40 bg-white hover:bg-[#9F5434]/5 hover:shadow-[0_24px_60px_-20px_rgba(159,84,52,0.18)]\"
          x-on:click=\"document.getElementById(\x27edit-account-type-journalist\x27).click(); chosen = true;\"
        >
          <div class=\"w-14 h-14 rounded-2xl flex items-center justify-center mb-7 bg-[#9F5434]/10 text-[#9F5434]\">
            ";
        // line 29
        yield from $this->load("cfc_media_hub:icon", 29)->unwrap()->yield(CoreExtension::toArray(["name" => "user", "size" => "w-6 h-6"]));
        // line 30
        yield "          </div>
          <div class=\"text-[11px] uppercase tracking-[0.16em] mb-2 text-[#9F5434] font-semibold\">Press</div>
          <h2 class=\"tracking-tight mb-3\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">Journalist</h2>
          <p class=\"text-neutral-500 leading-relaxed mb-7 text-[14px]\">
            Professional journalists requesting access to desks, meeting rooms and the podcast studio at CFC Media Hub.
          </p>
          <ul class=\"space-y-2.5 mb-7\">
            ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(["Desk · Free for international accredited journalists", "Meeting Room · Free for international accredited journalists", "Podcast Studio · 400 MAD / hour", "Valid press accreditation required"]);
        foreach ($context['_seq'] as $context["_key"] => $context["feature"]) {
            // line 38
            yield "              <li class=\"flex items-start gap-2.5 text-[13px] text-neutral-600\">
                ";
            // line 39
            yield from $this->load("cfc_media_hub:icon", 39)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 shrink-0 mt-0.5 text-[#0F6E56]"]));
            // line 40
            yield "                ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["feature"], "html", null, true);
            yield "
              </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['feature'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 43
        yield "          </ul>
          <button type=\"button\" class=\"w-full py-3.5 rounded-2xl flex items-center justify-center gap-2 transition-colors mt-7 bg-[#9F5434] hover:bg-[#8A4A2E] text-white font-semibold text-[14px]\">
            Continue as journalist
            ";
        // line 46
        yield from $this->load("cfc_media_hub:icon", 46)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4 group-hover:translate-x-0.5 transition-transform"]));
        // line 47
        yield "          </button>
        </div>

        <div
          class=\"rounded-3xl p-9 border cursor-pointer group transition-all border-neutral-200 bg-white hover:border-neutral-400 hover:shadow-[0_24px_60px_-20px_rgba(15,110,86,0.12)]\"
          x-on:click=\"document.getElementById(\x27edit-account-type-cfc-member\x27).click(); chosen = true;\"
        >
          <div class=\"w-14 h-14 rounded-2xl flex items-center justify-center mb-7 bg-neutral-100 text-neutral-600\">
            ";
        // line 55
        yield from $this->load("cfc_media_hub:icon", 55)->unwrap()->yield(CoreExtension::toArray(["name" => "building-2", "size" => "w-6 h-6"]));
        // line 56
        yield "          </div>
          <div class=\"text-[11px] uppercase tracking-[0.16em] mb-2 text-neutral-400 font-semibold\">Corporate</div>
          <h2 class=\"tracking-tight mb-3\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">CFC Member Company</h2>
          <p class=\"text-neutral-500 leading-relaxed mb-7 text-[14px]\">
            Employees of companies that are members of Casablanca Finance City community.
          </p>
          <ul class=\"space-y-2.5 mb-7\">
            ";
        // line 63
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(["Podcast Studio access only · 400 MAD / hour", "No access to Desks or Meeting Rooms", "Verified via professional company email"]);
        foreach ($context['_seq'] as $context["_key"] => $context["feature"]) {
            // line 64
            yield "              <li class=\"flex items-start gap-2.5 text-[13px] text-neutral-600\">
                ";
            // line 65
            yield from $this->load("cfc_media_hub:icon", 65)->unwrap()->yield(CoreExtension::toArray(["name" => "check-circle-2", "size" => "w-4 h-4 shrink-0 mt-0.5 text-neutral-300"]));
            // line 66
            yield "                ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["feature"], "html", null, true);
            yield "
              </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['feature'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 69
        yield "          </ul>
          <div class=\"mt-6 bg-[#9F5434]/[0.08] border border-[#9F5434]/25 rounded-xl px-4 py-3.5 flex items-start gap-3\">
            ";
        // line 71
        yield from $this->load("cfc_media_hub:icon", 71)->unwrap()->yield(CoreExtension::toArray(["name" => "alert-circle", "size" => "w-4 h-4 text-[#9F5434] shrink-0 mt-0.5"]));
        // line 72
        yield "            <div class=\"text-[12px] text-[#9F5434] leading-relaxed font-medium\">
              <span class=\"font-bold\">CFC Members have access to the Podcast Studio only.</span><br />
              Meeting Rooms and Desks are not available.
            </div>
          </div>
          <button type=\"button\" class=\"w-full py-3.5 rounded-2xl flex items-center justify-center gap-2 transition-colors mt-7 bg-neutral-900 hover:bg-neutral-800 text-white font-semibold text-[14px]\">
            Continue as company member
            ";
        // line 79
        yield from $this->load("cfc_media_hub:icon", 79)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4 group-hover:translate-x-0.5 transition-transform"]));
        // line 80
        yield "          </button>
        </div>
      </div>

      <div class=\"mt-8 flex items-center justify-center gap-2 text-[13px] text-neutral-400\">
        ";
        // line 85
        yield from $this->load("cfc_media_hub:icon", 85)->unwrap()->yield(CoreExtension::toArray(["name" => "shield-check", "size" => "w-4 h-4 text-[#0F6E56]"]));
        // line 86
        yield "        Your information is protected and will only be used for access verification.
      </div>

      <div class=\"mt-6 text-center text-[13px] text-neutral-500\">
        Already have an account?
        <a href=\"";
        // line 91
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sign_in_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[#9F5434] hover:underline underline-offset-2 font-semibold\">Sign in</a>
      </div>
    </div>
  </div>

  <div x-show=\"chosen\" x-cloak class=\"flex-1 flex items-center justify-center px-12 py-16\">
    <div class=\"w-full max-w-[520px]\">
      <div class=\"flex justify-center mb-10\">
        <img src=\"";
        // line 99
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-16 w-auto\" />
      </div>

      <div class=\"bg-white rounded-3xl border border-neutral-200 shadow-[0_24px_60px_-20px_rgba(15,110,86,0.08)] p-10\">
        <button type=\"button\" x-on:click=\"chosen = false\" class=\"flex items-center gap-1.5 text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors mb-7\">
          ";
        // line 104
        yield from $this->load("cfc_media_hub:icon", 104)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-left", "size" => "w-3.5 h-3.5"]));
        // line 105
        yield "          Change profile type
        </button>

        <h1 class=\"tracking-tight text-neutral-900 mb-1\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">Create your account</h1>
        <p class=\"text-neutral-500 mb-8 text-[14px]\">Journalists get free access to Desk &amp; Meeting Room. CFC Member employees get Studio access.</p>

        <div class=\"cfc-form-shell\" x-data=\"{ selectedCompany: null, emailValue: \x27\x27 }\">
          ";
        // line 112
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["form"] ?? null), "html", null, true);
        yield "
        </div>
      </div>

      <div class=\"mt-6 pt-6 text-center text-[13px] text-neutral-500\">
        Already have an account?
        <a href=\"";
        // line 118
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sign_in_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[#9F5434] hover:underline underline-offset-2 font-semibold\">Sign in</a>
      </div>
    </div>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "sign_in_url", "logo_url", "form"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:register-page";
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
        return array (  239 => 118,  230 => 112,  221 => 105,  219 => 104,  211 => 99,  200 => 91,  193 => 86,  191 => 85,  184 => 80,  182 => 79,  173 => 72,  171 => 71,  167 => 69,  156 => 66,  154 => 65,  151 => 64,  147 => 63,  138 => 56,  136 => 55,  126 => 47,  124 => 46,  119 => 43,  108 => 40,  106 => 39,  103 => 38,  99 => 37,  90 => 30,  88 => 29,  63 => 8,  61 => 7,  57 => 5,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:register-page", "themes/custom/cfc_media_hub/components/register-page/register-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 4, "for" => 37];
        static $filters = ["escape" => 3];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include", 1 => "for"],
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
