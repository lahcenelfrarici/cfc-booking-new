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

/* cfc_media_hub:payment-page */
class __TwigTemplate_03ef56edb23f75d2b8cbac416c4b631f extends Template
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
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--payment-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:payment-page"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:payment-page"));
        yield "<div class=\"border-b border-neutral-100 bg-white\">
  <div class=\"w-full max-w-[1440px] mx-auto px-12 h-20 flex items-center justify-between\">
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
        yield from $this->load("cfc_media_hub:journey-steps", 7)->unwrap()->yield(CoreExtension::toArray(["active" => [5]]));
        // line 8
        yield "    <a href=\"";
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"text-[13px] text-neutral-400 hover:text-neutral-700 transition-colors\">Cancel</a>
  </div>
</div>

<section class=\"bg-[#FCFCFB] min-h-[70vh]\">
  <div class=\"max-w-[960px] mx-auto px-12 py-16\">
    <div class=\"mb-10\">
      <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#0F6E56] font-semibold mb-3\">Step 5 · Payment</div>
      <h1 class=\"tracking-tight\" style=\"font-size: 48px; font-weight: 600; letter-spacing: -0.025em;\">
        Complete your booking.
      </h1>
    </div>

    <div class=\"grid grid-cols-12 gap-8\">
      <div class=\"col-span-5\">
        <div class=\"bg-white rounded-3xl border border-neutral-200 overflow-hidden sticky top-28\">
          <div class=\"px-7 py-5 bg-[#9F5434]/5 border-b border-neutral-100\">
            <div class=\"text-[12px] uppercase tracking-wide text-[#9F5434] font-semibold\">Reservation summary</div>
          </div>
          <div class=\"p-7 space-y-4\">
            <div class=\"flex items-center justify-between\">
              <div class=\"text-[13px] text-neutral-400\">Space</div>
              <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 30
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["space_label"] ?? null), "html", null, true);
        yield "</div>
            </div>
            <div class=\"flex items-center justify-between\">
              <div class=\"text-[13px] text-neutral-400\">Date</div>
              <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 34
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["date"] ?? null), "html", null, true);
        yield "</div>
            </div>
            <div class=\"flex items-center justify-between\">
              <div class=\"text-[13px] text-neutral-400\">Time</div>
              <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 38
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["time"] ?? null), "html", null, true);
        yield "</div>
            </div>
            <div class=\"flex items-center justify-between\">
              <div class=\"text-[13px] text-neutral-400\">Duration</div>
              <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 42
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["duration"] ?? null), "html", null, true);
        yield "</div>
            </div>
            <div class=\"flex items-center justify-between\">
              <div class=\"text-[13px] text-neutral-400\">Name</div>
              <div class=\"text-[14px] text-neutral-900 font-medium\">";
        // line 46
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</div>
            </div>
            ";
        // line 48
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["guest_names"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["guest"]) {
            // line 49
            yield "              <div class=\"flex items-center justify-between\">
                <div class=\"text-[13px] text-neutral-400\">Guest ";
            // line 50
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 50), "html", null, true);
            yield "</div>
                <div class=\"text-[14px] text-neutral-900 font-medium\">";
            // line 51
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["guest"], "html", null, true);
            yield "</div>
              </div>
            ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['guest'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 54
        yield "            <div class=\"border-t border-neutral-100 pt-4 mt-4\">
              <div class=\"flex items-center justify-between\">
                <div class=\"text-[13px] text-neutral-400\">Total</div>
                <div class=\"text-[14px] text-[#9F5434] font-bold\">";
        // line 57
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["total_label"] ?? null), "html", null, true);
        yield "</div>
              </div>
            </div>
            <div class=\"text-[11px] text-neutral-400 pt-2\">
              Ref: ";
        // line 61
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["reference"] ?? null), "html", null, true);
        yield "
            </div>
          </div>
        </div>
      </div>

      <div class=\"col-span-7\">
        <div class=\"cfc-form-shell\">
          ";
        // line 69
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["form"] ?? null), "html", null, true);
        yield "
        </div>
      </div>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "space_label", "date", "time", "duration", "user_name", "guest_names", "loop", "total_label", "reference", "form"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:payment-page";
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
        return array (  187 => 69,  176 => 61,  169 => 57,  164 => 54,  146 => 51,  142 => 50,  139 => 49,  122 => 48,  117 => 46,  110 => 42,  103 => 38,  96 => 34,  89 => 30,  63 => 8,  61 => 7,  57 => 5,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:payment-page", "themes/custom/cfc_media_hub/components/payment-page/payment-page.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 4, "for" => 48];
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
